<?php 
/**
* @version      4.9.2 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<div class="jshop" id="comjshop">

<table class = "jshop cart cartwishlist" id="comjshop">
    <tr>
        <th class="jshop_img_description_center" width = "20%">
            <?php print _JSHOP_IMAGE?>
        </th>
        <th class="product_name">
            <?php print _JSHOP_ITEM?>
        </th>    
        <th class="single_price" width = "15%">
            <?php print _JSHOP_SINGLEPRICE ?>
        </th>
        <th class="quantity" width = "15%">
            <?php print _JSHOP_NUMBER ?>
        </th>
        <th class="total_price" width = "15%">
            <?php print _JSHOP_PRICE_TOTAL ?>
        </th>
        <th class="remove_to_cart" width = "10%">
            <?php print _JSHOP_REMOVE_TO_CART ?>
        </th>
        <th class="remove" width = "10%">
            <?php print _JSHOP_REMOVE ?>
        </th>
    </tr>
    <?php 
    $i=1;
    foreach($this->products as $key_id=>$prod){
    ?> 
    <tr class = "jshop_prod_cart <?php if ($i%2==0) print "even"; else print "odd"?>">
        <td class = "jshop_img_description_center">
            <div class="mobile-cart">
                <?php print _JSHOP_IMAGE; ?>
            </div>
            <div class="data">
                <a href = "<?php print $prod['href']; ?>">
                    <img src = "<?php print $this->image_product_path ?>/<?php if ($prod['thumb_image']) print $prod['thumb_image']; else print $this->no_image; ?>" alt = "<?php print htmlspecialchars($prod['product_name']);?>" class = "jshop_img" />
                </a>
            </div>
        </td>
        <td class="product_name">
            <div class="mobile-cart">
                <?php print _JSHOP_ITEM; ?>
            </div>
            <div class="data">            
                <a href="<?php print $prod['href']?>">
                    <?php print $prod['product_name']?>
                </a>
                <?php if ($this->config->show_product_code_in_cart){?>
                    <span class="jshop_code_prod">(<?php print $prod['ean']?>)</span>
                <?php }?>
                <?php if ($prod['manufacturer']!=''){?>
                    <div class="manufacturer">
                        <?php print _JSHOP_MANUFACTURER?>: 
                        <span><?php print $prod['manufacturer']?></span>
                    </div>
                <?php }?>
                <?php print sprintAtributeInCart($prod['attributes_value']);?>
                <?php print sprintFreeAtributeInCart($prod['free_attributes_value']);?>
                <?php print sprintFreeExtraFiledsInCart($prod['extra_fields']);?>
                <?php print $prod['_ext_attribute_html']?>
            </div>
        </td>    
        <td class="single_price">
            <div class="mobile-cart">
                <?php print _JSHOP_SINGLEPRICE; ?>
            </div>
            <div class="data">
                <?php print formatprice($prod['price'])?>
                <?php print $prod['_ext_price_html']?>
                <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
                    <span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
                <?php }?>
                <?php if ($this->config->cart_basic_price_show && $prod['basicprice']>0){?>
                    <div class="basic_price">
                        <?php print _JSHOP_BASIC_PRICE?>: <span><?php print sprintBasicPrice($prod);?></span>
                    </div>
                <?php }?>
            </div>
        </td>
        <td class="quantity">
            <div class="mobile-cart">
                <?php print _JSHOP_NUMBER; ?>
            </div>
            <div class="data">
                <?php print $prod['quantity']?><?php print $prod['_qty_unit'];?>
            </div>
        </td>
        <td class="total_price">
            <div class="mobile-cart">
                <?php print _JSHOP_PRICE_TOTAL; ?>
            </div>
            <div class="data">
                <?php print formatprice($prod['price']*$prod['quantity']);?>
                <?php print $prod['_ext_price_total_html']?>
                <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
                    <span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
                <?php }?>
            </div>
        </td>
        <td class="remove_to_cart">
            <div class="mobile-cart">
                <?php print _JSHOP_REMOVE_TO_CART; ?>
            </div>
            <div class="data">
                <a class="button-img" href = "<?php print $prod['remove_to_cart'] ?>" >
                    <img src = "<?php print $this->image_path ?>images/reload.png" alt = "<?php print _JSHOP_REMOVE_TO_CART?>" title = "<?php print _JSHOP_REMOVE_TO_CART?>" />
                </a>
                <a class="btn btn-primary" href = "<?php print $prod['remove_to_cart'] ?>" >
                    <?php print _JSHOP_REMOVE_TO_CART?>
                </a>
            </div>
        </td>
        <td class="remove">
            <div class="mobile-cart">
                <?php print _JSHOP_REMOVE; ?>
            </div>
            <div class="data">
                <a class="button-img" href="<?php print $prod['href_delete']?>" onclick="return confirm('<?php print _JSHOP_CONFIRM_REMOVE?>')">
                    <img src = "<?php print $this->image_path ?>images/remove.png" alt = "<?php print _JSHOP_DELETE?>" title = "<?php print _JSHOP_DELETE?>" />
                </a>
            </div>
        </td>
    </tr>
    <?php 
    $i++;
    } 
    ?>
</table>

<?php print $this->_tmp_html_before_buttons?>

<div class = "jshop wishlish_buttons">
    <div id = "checkout">
    
        <div class = "pull-left td_1">
            <a href = "<?php print $this->href_shop ?>" class = "btn">
                <img src = "<?php print $this->image_path ?>/images/arrow_left.gif" alt = "<?php print _JSHOP_BACK_TO_SHOP ?>" />
                <?php print _JSHOP_BACK_TO_SHOP ?>
            </a>
        </div>
        
        <div class = "pull-right td_2">
            <a href = "<?php print $this->href_checkout ?>" class = "btn">
                <?php print _JSHOP_GO_TO_CART ?>
                <img src = "<?php print $this->image_path ?>/images/arrow_right.gif" alt = "<?php print _JSHOP_GO_TO_CART ?>" />
            </a>
        </div>
        
        <div class = "clearfix"></div>
    </div>
</div>

<?php print $this->_tmp_html_after_buttons?>

</div>