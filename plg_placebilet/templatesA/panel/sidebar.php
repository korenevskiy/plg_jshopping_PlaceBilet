<?php
/**
* @version      4.10.0 09.04.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die('Restricted access');

//$this->config->stock = FALSE; // Изменен Добавленно

use \Joomla\CMS\Uri\Uri as JUri;
 
//    echo "<pre>Имя stock: ";
//    var_dump($this->config->stock);
//    echo "</pre>"; 

// <editor-fold defaultstate="collapsed" desc="Скрипт">
if (empty($script)) {
//<script>   
static $script = <<< script
jQuery( function() {
        console.log(jQuery.fn.jquery);
        
        return;
        console.clear();
//        jQuery(".slider5").owlCarousel({  
////            items: 5,
//        });
        jQuery(".slider5").owlCarousel({ 
            items: 5,
            touchDrag: true,
            center: true,
            autoWidth: true,
            mouseDrag: true,
            autoplay: true,
            loop: true,
            nav: true
        });
            //   startPosition: 1, 
        
        return; 
//        console.log("carousel");
}); 
//setInterval(function(){ }, 100000);  
script;
JFactory::getDocument()->addScriptDeclaration($script);
}
//</script>// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Стиль">
if (empty($style)) {
//<script>   
static $style = <<< style
        
#j-sidebar-container.span2{
        display: none;
}
.admin.com_jshopping .container-main #content > div > div {
    display: flex;
    -flex-direction: column;
    -flex-direction: column;
    padding: 0 0 0 0px;
    justify-items: initial;
    display: flex;
    justify-content: space-between;
    justify-items: stretch;
    align-content: stretch;
    align-items: stretch;
    flex-wrap: wrap;
    padding: 0 0 0 00px;
    justify-items: initial;
}
.admin.com_jshopping .container-main #content > div > div  > div,
#_j-sidebar-container + table{
    float: none;
    width: 100%;
    width: auto;
    margin: 0;
    flex: 1;
}

#_j-sidebar-container + table{ 
    margin-left: 20px;
}
.admin.com_jshopping .container-main #content > div > div> .j-sidebar-visible {
        display: none;
}
        
#j-sidebar-container_{
    position: absolute;
            z-index: 9;
}        
.sidebar-left,
.admin.com_jshopping .container-main #content > div > div  > .sidebar-left{
    text-align: center;
    text-align-last: center;
    width: 60px;;
    flex-basis: 60px;
    flex-basis: 60px;
    flex-grow: 0;
    flex-shrink: 0;
    align-self: stretch;
    justify-self: stretch;
            z-index: 9;
    -position: absolute;
     overflow: visible;
    margin-right: 10px;
}
.sidebar-left.hide{
    width: auto;
}
.sidebar-left ul{
    display: flex;
    flex-direction: column;
    width: 60px;
    flex-basis: auto;
    flex: auto;
    min-width: 0;
    list-style: none;
    margin: 0;
	border: 1px solid #88a1;
	border-radius:  5px;padding: 10px 0;
    position: static;
    position: sticky;
    top:0;
    top: 90px;
    transition: 0.7s;
	backdrop-filter: blur(20px);
}
.sidebar-left ul:hover{
    width: 120px;
    width: 210px;
    -flex-basis: 130px; 
}
        
.sidebar-left.show li{
    text-align: left;
    text-align-last: left;
    
    text-align: center;
    text-align-last: center;
}
.sidebar-left li{
    margin: 5px;
}
.sidebar-left li img{
    width: 48px;
    height: 48px;
    flex-grow: 0;
    flex-shrink: 0;
}
.sidebar-left li label{
        
    height: 48px;
    margin:0 0px;
/*    width: 0; */
	width: 200px;
    display: flex;
        overflow: hidden;
        transition: 0.8s;
        display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    justify-content: flex-start;
	cursor: pointer;
}
.sidebar-left ul:hover li label{
/*    width: 80px;*/
    margin:0 5px;
}
.sidebar-left li a{
    display: inline-block;
    display: flex;
        border-radius: 5px;
    border: 1px solid transparent ;
    transition: 0.8s;
        text-decoration: none;
	overflow: hidden;
	cursor: pointer;
}
.sidebar-left li a:hover{
    border-color: gray;
}
.sidebar-left btn{
    margin: 0 auto;
}
.admin.com_jshopping .container-main #content > div > div > div#system-message-container,
#system-message-container{
    margin 100%;
     flex-basis: 100%;   
}
		
.container-main main{
	display: grid;
	column-gap: 10px;
	grid-template-columns: 60px 1fr;
    grid-template-areas:
        "message message"
        ". ..."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        ". ."
        "sidebar content";
}	
.com_jshopping main > *{
	grid-column: 2/3;
	margin-left:60px;
}			
.com_jshopping main #system-message-container{
	grid-area: message;
	margin-left: 0px;
}		
.com_jshopping main .sidebar-left.show,
#j-sidebar-container2{
	grid-area: sidebar;
	margin-left: 0px;
}		
.com_jshopping main  .sidebar-left + div,
.com_jshopping main  #j-main-container{
	grid-area: content;
	margin-left: 0px;
}
style;
JFactory::getDocument()->addStyleDeclaration($style);
}
//</script>// </editor-fold>


$sidebar = JFactory::$application->getUserState('sidebar_bilet', 'show');  
$sidebarInput = JFactory::$application->input->getCmd('sidebar');
if($sidebarInput){
    JFactory::$application->setUserState('sidebar_bilet', $sidebarInput);
    $sidebar=$sidebarInput;
}
$sidebarDisplay = $sidebar == 'show' ? 'inline-block' : 'none';
$sidebarDisplay = "flex";
$sidebarUri = $sidebar == 'show'?'hide':'show';
$sidebarButton = $sidebar == 'show' ? JText::_('JHide') : JText::_('JShow');
JUri::getInstance()->setVar('sidebar', $sidebarUri);

$s = '/';// DIRECTORY_SEPARATOR;
$images = JUri::root()."components{$s}com_jshopping{$s}images{$s}";

$base = JUri::base();

//JHtml::_('formbehavior.chosen', '.chosen-select');
//$menu_add = [[ JText::_('JoomShopping'), 'index.php?option=com_jshopping', 'shop.png', 1]];
?>
<!--<div style="_position: static; width: 60px; ">-->
<div xid="_j-sidebar-container" id="j-sidebar-container2" class="span2 sidebar-left <?= $sidebar?>">
    
   <!-- <a href="<?= '#'//JUri::getInstance()->toString() // "?&sidebar=".$sidebar ?>"
       onclick="//jQuery('.sidebar-left li .title').toggle(400);breack;" class="btn fide"><?=$sidebarButton?></a> -->
    <ul style="">
        <li style="height: 20px;">😃<?= JText::_('Hi!') ?> <span class="smiley-2 large-icon"></span></li> 
    <?php foreach ($this->menu as $type => $item):
        echo "<li>";    
        echo "<a href=\"$item[1]\" title=\"$item[0]\">";
        echo "<img src=\"{$item[2]}\" title=\"$item[0]\">";
        echo "<label class=\"title x$sidebar\"  style=\"display: $sidebarDisplay;\" >$item[0]</label>";
        echo "</a></li>";    
    endforeach;
    ?>
    </ul>
</div>
<!--</div>-->