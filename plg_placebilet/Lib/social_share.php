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
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use \Joomla\CMS\Language\Text as JText;

/**
 * Description of socialshare
 *
 * @author koren
 */ 
class JSocial_Share{
    
    private $locale;
    private $params; 
    
    public function __construct(&$params) { 
        
        $this->params = $params;
            
        $this->locale = JFactory::getLanguage()->getTag();
            
        JFactory::getDocument()->addStyleSheet(JURI::root(true).'/plugins/jshopping/placebilet/media/jsocial_share.css');
    }
    
    public static function getInstance(&$params){
        $social = new JSocial_Share($params);
        
        return $social;
        //$social->onBeforeDisplayProductView($view);
    }
    
	
    public function onBeforeDisplayProductView(&$view) {  
        
        
        $CategoriesRedirect = $this->params->get('CategoriesRedirect', FALSE);
        $product_categories = $view->get('product')->product_categories;  
        $date_event = $view->get('product')->date_event;  
        $product_id = $view->get('product')->product_id;  
        
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
//        JUri::base();
        $link = ($cat_id)?(JUri::root().SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$cat_id")):JURI::current();
        $link = ($cat_id)?(JUri::root().SEFLink("index.php?option=com_jshopping&controller=product&task=view&category_id=$cat_id&product_id=$product_id", 1)):JURI::current();
//        toPrint($link,'$link');
        $url = &$link;
//        $date = JFactory::getDate($date_event)-> format(DATE_FORMAT_FILTER_DATE);
//        toPrint($date,'$date');
            
        
//toPrint($date_event,'$product->date_event');

        $date = JHTML::_('date', $date_event, JText::_('DATE_FORMAT_LC3')." h:m");

//toPrint($date,'$date');
        
        $jshopConfig = JSFactory::getConfig();
        $doc = JFactory::getDocument();
        $product = $view->product;
        $name_product = htmlentities($product->name.' '.$date, ENT_QUOTES, "UTF-8");
        $ogurl = '<meta property="og:url" content="'.$link.'"/>';
        //$ogtype = '<meta property="og:type" content="website"/>';
        $ogtitle = '<meta property="og:title" content="'.$name_product.'"/>';
        $doc->addCustomTag($ogurl);
        $doc->addCustomTag($ogtype);
        $doc->addCustomTag($ogtitle);
        if ($product->image){
            $ogimage = '<meta property="og:image" content="'.$jshopConfig->image_product_live_path.'/'.$product->image.'"/>';
            $doc->addCustomTag($ogimage);
        }
        if ($product->description){
            $ogdescription = '<meta property="og:description" content="'.(strip_tags($product->description)).'"/>';
            $doc->addCustomTag($ogdescription);
        }

//        $uri = JURI::getInstance();
//        //$url = $uri->getScheme() ."://" . $uri->getHost() . $uri->getPath();
//		$url = '//'.$uri->getHost().$uri->getPath();
                
                
        $view->product->product_full_image = getPatchProductImage($view->product->image, 'full');
        $_tmp_product_html = '';
        if ($this->params->get("facebookLikeButton", 1)){
            $_tmp_product_html .= '<div class="facebook-like-button">'.$this->getFacebookLikeButton($this->params, $url, $name_product).'</div>';
        }
        if ($this->params->get("facebookShareButton", 1)){
            $_tmp_product_html .= '<div class="facebook-share">'.$this->getFacebookShare($this->params, $url).'</div>';
        }
        if ($this->params->get("pinterestButton", 1)){
            $_tmp_product_html .= '<div class="pinterest">'.$this->getPinterestButton($this->params, $url, $jshopConfig->image_product_live_path.'/'.$product->image).'</div>'; 
        }
        if ($this->params->get("twitterButton", 1)){
            $_tmp_product_html .= '<div class="tweet-button">'.$this->getTweetButton($this->params, $url, $name_product).'</div>';
        }
        if($this->params->get("plusButton")) {
            $_tmp_product_html .= '<div class="google-plus-one-button">'.$this->getGooglePlusOne($this->params, $url).'</div>';
        }
        if ($this->params->get("vkShareButton", 1)){
            $_tmp_product_html .= '<div class="vk-share-button">'.$this->getVkShareButton($this->params, $url).'</div>';
        }
        $_tmp_product_html .= '<div style="clear:both;"></div>';
        
        $_tmp_product_html = "<div class=\"social_share\">$_tmp_product_html</div>";
        
		return $_tmp_product_html;
		
        switch ($this->params->get('socialposition', 2)) {
            case 1 :
                $view->_tmp_product_html_start = $_tmp_product_html.$view->_tmp_product_html_start;
                break;
            case 3 :
                $view->_tmp_product_html_end = $_tmp_product_html.$view->_tmp_product_html_end;
                break;
            default:
                $view->_tmp_product_html_after_buttons = $_tmp_product_html.$view->_tmp_product_html_after_buttons;
                break;    
        }
    }
    
    public function getVkShareButton($url){
		$params = $this->params;
        JFactory::getDocument()->addScript('//vk.com/js/api/share.js?91');
        
        $buttonLogoVersion = '';
        $buttonStyle = $params->get("vkShareStyle", 'round');
        $buttonText = $params->get('vkShareText', 'Share');
        if ($buttonStyle == 'custom'){
            $buttonText = '<img src=\"//vk.com/images/share_32.png\" width=\"32\" height=\"32\" />';
            if ($params->get('vkShareLogoVersion', 'russian') == 'eng'){
                $buttonText = '<img src=\"//vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />';
            }
        }
        
        if ($params->get('vkShareLogoVersion', 'russian') == 'eng'){
            $buttonLogoVersion = ', eng: 1';
        }
//        toPrint($url,'$url');
//        toPrint($buttonText,'$buttonText');
        return '<script type="text/javascript"><!--
                    document.write(VK.Share.button({url: "'.$url.'"},{type: "'.$buttonStyle.'", text: "'.$buttonText.'"'.$buttonLogoVersion.'}));
                --></script>';
    }
    
    public function getGooglePlusOne($url){
		$params = $this->params;
        $html = ''; $annotation = ''; $size = '';
        
        if ($params->get("plusAnnotation") == 'inline') $annotation = 'annotation="inline"';
        else if ($params->get("plusAnnotation") == 'none') $annotation = 'annotation="none"';

        if ($params->get("plusType")) $size = 'size="'. $params->get("plusType", "medium") .'"';

        $html = '<script type="text/javascript" src="//apis.google.com/js/plusone.js"> 
        {lang: "' . $params->get('plusLocale') . '"} </script>';
        if (!$params->get("html5syntax"))
            $html .= '<g:plusone '. $annotation .' ' . $size . '" href="' . $url . '"></g:plusone>';
        else {
            if (!empty($size)) $size = 'data-' . $size;
            if (!empty($annotation)) $annotation = 'data-'.$annotation;
            $html .= '<div class="g-plusone" '. $annotation .' '. $size . '"  data-href="' . $url . '"></div>';
        }
        
        return $html;
    }

    public function getTweetButton($url, $name_product){
		$params = $this->params;
         $text = array(
                    'en' => 'Tweet',
                    'de' => 'Twittern',
                    'ru' => 'Твитнуть'
        );
        $html = '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'. $url .'" data-text="'. $name_product .'" data-via="'. $params->get('twitterName', '') .'" data-lang="'. $params->get('twitterLanguage', 'en') .'">'. $text[$params->get('twitterLanguage', 'en')] .'</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
        return $html;
    }
    
    public function getFacebookShare($url){
		$params = $this->params;
        //added in 4.0.2 version
		$html = '';
        $locale = $params->get('facebookLocaleShare', 'en_US');
        if (!$params->get("facebookLikeButton", 1) && !$facebookLikeRenderer){
            $html .= '<div id="fb-root"></div>';
        }
        $html .= '<script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/'. $locale .'/all.js#xfbml=1&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
                }(document, "script", "facebook-jssdk"));</script>';
        $html .= '<fb:share-button href="'. $url .'"'
                . 'layout="button"</fb:share-button>'; 

        //old in 4.0.1 version
        // $html = '<script type="text/javascript">var fbShare = {url: "' .$url. '", size: "' .$params->get("facebookShareTextSize", "small"). '", google_analytics: "false"}</script><script src="//widgets.fbshare.me/files/fbshare.js" type="text/javascript"></script>'; 
        return $html;
    }
    
    public function getFacebookLikeButton($url, $product_title){
		$params = $this->params;
//		$tag = \Joomla\CMS\Factory::getApplication()->getLanguage()->getTag();
		$tag = $this->locale;
		$html = '';
        $locale = ($params->get('facebookDynamicLocale', 1)) ? str_replace("-", "_", $this->locale) : $params->get('facebookLocale', 'en_US');
        $height = (strcmp("box_count", $params->get("facebookLayoutStyle","button_count"))==0) ? 80 : 20;
        $facebookLikeRenderer = $params->get('facebookLikeRenderer', 1);
        if (!$facebookLikeRenderer){ //Iframe
            $html = '<iframe src="//www.facebook.com/plugins/like.php?href='.$url.'&amp;
            send=false&amp;
            layout='. $params->get("facebookLayoutStyle","button_count") .'&amp;
            width='. $params->get('facebookLikeWidth', '100') .'&amp;
            show_faces='. $params->get('facebookShowFaces', 'false') .'&amp;
            action='. $params->get('facebookVerbToDisplay', 'like') .'&amp;
            colorscheme='. $params->get('facebookColorScheme', 'light') .'&amp;
            font='. $params->get('facebookLikeFont', 'arial') .'&amp;
            height='. $height .'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; 
            width:'. $params->get('facebookLikeWidth', '100') .'px; 
            height:'. $height .'px;" allowTransparency="true"></iframe>';                
        }else{
            $html = '<div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/'. $locale .'/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, "script", "facebook-jssdk"));</script>';    

            if($facebookLikeRenderer == 1){//XFBML
                 $html .= '<fb:like href="'. $url .'" 
                        send="'. $params->get('facebookSendButton', 'false') .'" 
                        layout="'. $params->get("facebookLayoutStyle","button_count") .'" 
                        width="'. $params->get('facebookLikeWidth', '100') .'" 
                        show_faces="'. $params->get('facebookShowFaces', 'false') .'" 
                        font="'. $params->get('facebookLikeFont', 'arial') .'"
                        action="'. $params->get('facebookVerbToDisplay', 'like') .'"
                        colorscheme="'. $params->get('facebookColorScheme', 'light') .'"> 
                     </fb:like>';  
            }else{//HTML5 
                $html .= '<div class="fb-like" data-href="'. $url .'" 
                        data-send="'. $params->get('facebookSendButton', 'false') .'" 
                        data-layout="'. $params->get("facebookLayoutStyle","button_count") .'" 
                        data-width="'. $params->get('facebookLikeWidth', '100') .'" 
                        data-show-faces="'. $params->get('facebookShowFaces', 'false') .'" 
                        data-font="'. $params->get('facebookLikeFont', 'arial') .'"
                        data-action="'. $params->get('facebookVerbToDisplay', 'like') .'"
                        data-colorscheme="'. $params->get('facebookColorScheme', 'light') .'">
                     </div>';     
            } 
        }

        return $html;
    }
	
	public function getPinterestButton($url, $imageUrl){
		$params = $this->params;
		$html = '';
        $html .= '<a href="//pinterest.com/pin/create/button/?url='.$url.'&media='.$imageUrl.'" class="pin-it-button" count-layout="none"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
        $html .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
		
		return $html;
	}
}