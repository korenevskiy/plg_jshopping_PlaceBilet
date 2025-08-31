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

use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper;
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');
//require_once (JPATH_PLUGINS.'/jshoppingadmin/PlaceBiletAdmin/models/products.php');
require_once( JPATH_COMPONENT.'/models/products.php' );

class JshoppingModelProducts_mod extends JshoppingModelProducts{
    
//    function getPrepareDataSave($input){
//		return parent::getPrepareDataSave($input);
////        return $post;
//    }
    
	/*
	 * Сохранение атрибутов Которые не относятся к билетам.
	 * Атрибуты не относящиеся к плагину билетов
	 */
    function saveAttributesPlace($product, $product_id, $post){
      
        $dispatcher = \JFactory::getApplication();
 //  Сохранения зависимых атрибутов.        
        $productAttribut = JSFactory::getTable('productAttribut', 'jshop');
        $productAttribut->set("product_id", $product_id);
        
        $list_exist_attr = $product->getAttributes();
        if (isset($post['product_attr_id'])){
            $list_saved_attr = $post['product_attr_id'];
        }else{
            $list_saved_attr = array();
        }        
        foreach($list_exist_attr as $v){
            if (!in_array($v->product_attr_id, $list_saved_attr)){
                $productAttribut->deleteAttribute($v->product_attr_id);
            }
        }
        
//toPrint($post,'$post',0,'message',true);
        
        if (is_array($post['attrib_price'])){
            foreach($post['attrib_price'] as $k=>$v){
                $a_price = saveAsPrice($post['attrib_price'][$k]);
                $a_old_price = saveAsPrice($post['attrib_old_price'][$k]);
                $a_buy_price = saveAsPrice($post['attrib_buy_price'][$k]);
                $a_count = $post['attr_count'][$k];
                $a_ean = $post['attr_ean'][$k];
                $a_weight_volume_units = $post['attr_weight_volume_units'][$k];
                $a_weight = $post['attr_weight'][$k];
                
                if ($post['product_attr_id'][$k]){
                    $productAttribut->load($post['product_attr_id'][$k]);
                }else{
                    $productAttribut->set("product_attr_id", 0);
                    $productAttribut->set("ext_attribute_product_id", 0);
                }
                $productAttribut->set("price", $a_price);
                $productAttribut->set("old_price", $a_old_price);
                $productAttribut->set("buy_price", $a_buy_price);
                $productAttribut->set("count", $a_count);
                $productAttribut->set("ean", $a_ean);
                $productAttribut->set("weight_volume_units", $a_weight_volume_units);
                $productAttribut->set("weight", $a_weight);
                foreach($post['attrib_id'] as $field_id=>$val){
                    $productAttribut->set("attr_".intval($field_id), $val[$k]);
                }
                $dispatcher->triggerEvent('onBeforeProductAttributStore', array(&$productAttribut, &$product, &$product_id, &$post, $k));
                if ($productAttribut->check()){
                    $productAttribut->store();
                }
            }
        }        
//  Сохранения НЕзависимых атрибутов.        
        $productAttribut2 = JSFactory::getTable('productAttribut2', 'jshop');
        $productAttribut2->set("product_id", $product_id);
        $productAttribut2->deleteAttributeForProduct();

//toPrint($product_id,'$product_id',0,'message',true);
        
        if (is_array($post['attrib_ind_id'])){
            foreach($post['attrib_ind_id'] as $k=>$v){
                $a_id = intval($post['attrib_ind_id'][$k]);
                $a_value_id = intval($post['attrib_ind_value_id'][$k]);
                $a_price = saveAsPrice($post['attrib_ind_price'][$k]);
                $a_mod_price = $post['attrib_ind_price_mod'][$k];
                
                
//toPrint([$a_id,$a_value_id,$a_price,$a_mod_price],'$prod_attr2',0,'message',true);
                
                $productAttribut2->set("id", 0);
                $productAttribut2->set("product_id", $product_id);
                $productAttribut2->set("attr_id", $a_id);
                $productAttribut2->set("attr_value_id", $a_value_id);
                $productAttribut2->set("price_mod", $a_mod_price);
                $productAttribut2->set("addprice", $a_price);
                $dispatcher->triggerEvent('onBeforeProductAttribut2Store', array(&$productAttribut2, &$product, &$product_id, &$post, $k));
                if ($productAttribut2->check()){
                    $productAttribut2->store();
                }
            }
        }
        extract(JSHelper::js_add_trigger(get_defined_vars(), "after"));    
    }
    
    
}
?>