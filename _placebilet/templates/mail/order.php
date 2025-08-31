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

use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die('Restricted access');
//return FALSE;

$Offers = $this->Offers;
$order = $this->order;
$cart = $this->cart;

$styletable=' style="width: auto; border: 1px solid gray;" ';
$stylecell=' style="width: auto; border-bottom: 1px solid gray;" ';
//        toLog('','~ORDER!!!!!!!!! ','day');
//        return;
 
$fields_order = get_object_vars($order);
unset($fields_order['order_hash']);
unset($fields_order['file_hash']);
unset($fields_order['ip_address']);
unset($fields_order['package_tax_ext']);
unset($fields_order['payment_tax_ext']);
unset($fields_order['shipping_tax_ext']);
unset($fields_order['order_tax_ext']); 

//print_r($fields_order);
echo "<table $styletable >";
foreach ($fields_order as $field_name => $field_value){
    if(is_string($field_value))
        $field_value = trim($field_value);
    if($field_value)
        echo "<tr><td $stylecell>".JText::_($field_name)."</td><td $stylecell>$field_value </td></tr>";
}
echo "</table>";


echo "<hr><hr> ";



foreach ($cart->products as $product_name => $product){
    ksort($product);
    $prod = (object)$product;
//    $prod = new stdClass;
//    foreach ($product as $name => $value)
//        $prod->$name = $value;
    echo "<br><br><hr><h4  style='width: auto;'>$prod->product_name / </h4> "
            . " <h4  style='width: auto;'>".JText::_('date_event')." $prod->date_event / </h4>  ".JText::_('count_places').": $prod->count_places  "
            . "<br>$prod->price ".JText::_('price')." $prod->price_places ".JText::_('price_places')."";
    echo "<br>[category_id=$prod->category_id; product_id=$prod->product_id;]<br>";
    
//    toPrint($prod,'~$product',0);
//    toPrint($product->attributes_value,'~$product->attributes_value',0);
//        print_r($product->attributes_value);
    echo "<table $styletable >";
    foreach ($prod->attributes_value as $i => $place){
        echo "<tr><td $stylecell><h4>$place->attr</h4></td><td $stylecell><h4>$place->value ".JText::_('place')."</h4></td><td $stylecell><h5>$place->addprice ".JText::_('addprice')."</h5></td>";
        echo "<td $stylecell> - attr_id:$place->attr_id; value_id:$place->value_id; OfferId:$place->OfferId; id:$place->id; </td></tr>";
    }
    echo "</table>"; 
}


echo "<hr><hr> ";

$cart;
echo "<dl>";
echo "<dt>".JText::_('count_product')."</dt><dd>$cart->count_product</dd>";
echo "<dt>".JText::_('count_places')."</dt><dd>$cart->count_places</dd>";
echo "<dt>".JText::_('price_product_brutto')."</dt><dd>$cart->price_product_brutto</dd>";
echo "<dt>".JText::_('price_product')."</dt><dd>$cart->price_product</dd>";
echo "<dt>".JText::_('summ')."</dt><dd>$cart->summ</dd>"; 
echo "</dl>";

echo "<hr><br>";

$order_total = $fields_order->order_total;
$order_subtotal = $fields_order->order_subtotal;
$order_date = $fields_order->order_date;
$order_m_date = $fields_order->order_m_date;

//echo JText::_('order_total').": $order_total<br>";
//echo JText::_('order_subtotal').": $order_subtotal<br>";
//echo JText::_('order_date').": $order_date<br>";
//echo JText::_('order_m_date').": $order_m_date<br>"; 

//echo "<hr><hr> ";
return;

//$fields_contact = [];

//unset($fields_order['']);
//unset($fields_order['']);
 