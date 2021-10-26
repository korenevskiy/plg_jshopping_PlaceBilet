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
<ul class = "jshop" id = "jshop_menu_order" style="list-style: none;display: flex;">
  
    <?php foreach($this->steps as $k=>$step){?>
      <li class = "jshop_order_step <?php print $this->cssclass[$k]?>">
        <?php print $step;?>
      </li>
    <?php }?>
</ul>