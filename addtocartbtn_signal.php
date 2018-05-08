<?php
/**
 *
 * loads the add to cart button
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link ${PHING.VM.MAINTAINERURL}
 * @copyright Copyright (c) 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @version $Id: addtocartbtn.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
$doc=JFactory::getDocument();
$doc->addStyleSheet(JURI::base()."plugins/system/vmfxbot/assets/vmfxbotbtns.css");
if(!class_exists('FxbotmarketProduct')) {
  include_once JPATH_ROOT.'/components/com_fxbotmarket/helpers/product.php';
  }
if(array_key_exists('fxbotmarket_type_of_product', $GLOBALS)){
    $type_of_product = $GLOBALS['fxbotmarket_type_of_product'];
}else{
    $type_of_product = 1;//signal by default
}

if(array_key_exists('fxbotmarket_product', $GLOBALS)){
    $fx_product = $GLOBALS['fxbotmarket_product'];
}else{
    $fx_product = false;
}

if($viewData['orderable']) {
    
    if($type_of_product == 1){
        echo '<input type="submit" name="addtocart" id="addtocartbtn" class="addtocart-button" value="'.vmText::_( 'Copy robot' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" />';
    }elseif(FxbotmarketProduct::ifDownloadableTypeOfProduct ($type_of_product)){
        echo '<input type="submit" name="addtocart" id="addtocartbtn" class="addtocart-button" value="'.vmText::_( 'Order now' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" />';
    }elseif(FxbotmarketProduct::ifEaTypeOfProduct ($type_of_product)){
        if(is_object($fx_product) && isset($fx_product->id_product) && $fx_product->id_product > 0){
            echo '<input type="hidden" name="fx_product_rent" id="fx_product_rent" value="0" >';
            echo '<input type="hidden" name="fx_product_demo" id="fx_product_demo" value="0" >';
            if($fx_product->price > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" id="addtocartbtn" onclick="jQuery(\'#fx_product_rent\').val(100); " class="addtocart-button fxbuybtn" value="'.vmText::_( 'Buy:  '.FxbotmarketProduct::formatMoney($fx_product->price, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> '
                . '</div>';
            }
            if($fx_product->rent1 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(1); " id="addtocartbtn1" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 1 month:  '.FxbotmarketProduct::formatMoney($fx_product->rent1, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent3 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(3);" id="addtocartbtn3" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 3 monthes:  '.FxbotmarketProduct::formatMoney($fx_product->rent3, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent6 > 0){
                echo '<div class="fx_product_price" >'
                . '<input onclick="jQuery(\'#fx_product_rent\').val(6);" type="submit" name="addtocart" id="addtocartbtn6" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 6 monthes:  '.FxbotmarketProduct::formatMoney($fx_product->rent6, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent12 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(12);" id="addtocartbtn12" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 1 year:  '.FxbotmarketProduct::formatMoney($fx_product->rent12, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            $demo_file = FxbotmarketProduct::getDemoFile($fx_product->id_product);
            if($demo_file){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_demo\').val('.(int)$demo_file->id_product.');" '
                . 'id="addtocartbtndemo" class="addtocart-button fxdemobtn" value="'.vmText::_( 'Free demo  ').'" title="'.vmText::_( 'Try demo first' ).'" /> '
                . '</div>';
            }
            /*
                            $fx_product->rent1 = $fxbot_product->rent1;
                            $fx_product->rent3 = $fxbot_product->rent3;
                            $fx_product->rent6 = $fxbot_product->rent6;
                            $fx_product->rent12 = $fxbot_product->rent12;
             *              */
        }
    }
    
} else {
	echo '<span name="addtocart" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" >'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</span>';
}

?>
<script type="text/javascript">
   jQuery(document).ready(function() {
      /*jQuery("#addtocartbtn").click(function(event){
          var result = confirm("Are You sure?");
          if(result){
              return true;
          }else{
              event.preventDefault();
              return false;
          }
      }); 
      */
   }); 
   
</script>