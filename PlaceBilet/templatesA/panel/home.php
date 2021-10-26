<?php 
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<?php print $this->tmp_html_start?>
<div>
    <style>
        #_j-sidebar-container{
            position: absolute;
            left: 30px;
            display: none;
        }
        .panelhome{
            display: flex;
        }
        .panelhome > div{
            flex: auto 1;
        }
        #cpanel{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            justify-content: center;
            justify-content: space-evenly;
            align-content: flex-start;
        }
        #cpanel > div{
            flex: auto 1;
            max-width: 125px;
        }
        .infobilet{
            margin: 20px;
        }
        #contacts hr{
            border-top: 1px solid darkgray;
        }
        #contacts td{
            font-weight:normal;
        }
        #cpanel div.icon a{
            transition: 0.6s;
            background-color: transparent;
        }
        #cpanel div.icon a:hover{
            background-color: #EBF0F3;
        }
        .text{
            display: flex;
            flex-wrap: wrap;
        }
        .text > img{
            -flex-basis: 150px;
            align-self: flex-start;
            justify-self: flex-start;
        }
    </style>
    <div  class="panelhome" style=" ">
 
    <div id="cpanel" width="40%" style=" flex: 4;">
       <?php displayMainPanelIco(); ?>
    </div>
 
 
    <div id="contacts" style="vertical-align:top; flex: 5;">
        <table cellpadding="0" cellspacing="0" width="100%" style="border-radius: 10px;">
            <tr>
                <td><img src="plugins/jshopping/PlaceBilet/media/logo.jpg" alt="<?=   JText::_('JPLUGIN')?>" /><br>
                    <div style="margin: 20px 30px; font:bold 18pt  'Helvetica Neue', Helvetica, Arial, sans-serif;  "><?=   JText::_('JSHOP_PLACE_BILET_NAME')?></div>
                </td>
            </tr>
            <tr>
                <td valign="middle">
                    <img src="components/com_jshopping/images/phone.gif" align="left" border="0">
                    <div>Tel. +7 900-488-12-00</div>
                </td>
            </tr>
            <tr>
                <td valign="middle" class="text">
                    <img src="components/com_jshopping/images/at.gif" align="left" border="0">
                    <div>Web. <a href="//www.explorer-office.ru/" target="_blank">www.explorer-office.ru</a>
                        <br>VKontakte: <a href="//vk.com/placebilet" target="_blank">www.vk.com/placebilet</a>
                    <br>FaceBook: <a href="//fb.com/groups/placebilet/" target="_blank">www.fb.com/groups/placebilet</a>
                    <br>E-mail: <a href="mailto:info@explorer-office.ru" target="_blank">info@explorer-office.ru</a> 
                    
                    
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="middle">
                     <hr>
                    
                    
                    <div class="infobilet"><?= JText::_('JSHOP_PLACE_BILET_DEMO')?></div>
                </td>
            </tr>
            
        </table>
    </div>
     
 </div>

</div>
<?php print $this->tmp_html_end?>