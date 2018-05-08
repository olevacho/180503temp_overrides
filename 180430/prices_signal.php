<?php
/**
 *
 * Show the product prices
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link ${PHING.VM.MAINTAINERURL}
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_showprices.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
$product = $viewData['product'];
$virtuemart_product_id = $product->virtuemart_product_id;
$currency = $viewData['currency'];
if(!class_exists('FxbotmarketProduct')) {
  include_once JPATH_ROOT.'/components/com_fxbotmarket/helpers/product.php';
}
//find type of product
$fxbot_product =   FxbotmarketProduct::getFxbotProductByVid($virtuemart_product_id);
if(($fxbot_product !== false) && is_object($fxbot_product) && isset($fxbot_product->id) && ($fxbot_product->id > 0)){
                            $type_of_product = $fxbot_product->typeofproduct > 0? $fxbot_product->typeofproduct: 1;
                            //Signal = 1,  Robot (MT4 EA) =2,Robot (MT5 EA) = 3, Indicator = 4,Script = 5,Software = 6,eBook (PDF) = 7, TAP = 1000
                        }else{
                            $type_of_product = 1;//Signal by default
                        }
if($type_of_product == 1){//only for signal products we need to add
    //monthly flat fee
    
    $monthly_flat_see = FxbotmarketProduct::getPaypalMontlyFlatFee();  
    if( is_array($product->prices)){
        $product->prices = FxbotmarketProduct::addPaypalMonthlyFee($product->prices,$monthly_flat_see);
    }
}
?>
<div class="product-price" id="productPrice<?php echo $product->virtuemart_product_id ?>">
	<?php
	if (!empty($product->prices['salesPrice'])) {
		//echo '<div class="vm-cart-price">' . vmText::_ ('COM_VIRTUEMART_CART_PRICE') . '</div>';
	}

	if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) {
		$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
		?>
		<a class="ask-a-question bold" href="<?php echo $askquestion_url ?>" rel="nofollow" ><?php echo vmText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
		<?php
	} else {
	//if ($showBasePrice) {
		echo $currency->createPriceDiv ('basePrice', 'COM_VIRTUEMART_PRODUCT_BASEPRICE', $product->prices);
		//if (round($product->prices['basePrice'],$currency->_priceConfig['basePriceVariant'][1]) != $product->prices['basePriceVariant']) {
			echo $currency->createPriceDiv ('basePriceVariant', 'Monthly Subscription Fee', $product->prices);
		//}

	//}
	echo $currency->createPriceDiv ('variantModification', 'COM_VIRTUEMART_PRODUCT_VARIANT_MOD', $product->prices);
	if (round($product->prices['basePriceWithTax'],$currency->_priceConfig['salesPrice'][1]) != round($product->prices['salesPrice'],$currency->_priceConfig['salesPrice'][1])) {
		echo '<span class="price-crossed" >' . $currency->createPriceDiv ('basePriceWithTax', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX', $product->prices) . "</span>";
	}
	if (round($product->prices['salesPriceWithDiscount'],$currency->_priceConfig['salesPrice'][1]) != round($product->prices['salesPrice'],$currency->_priceConfig['salesPrice'][1])) {
		echo $currency->createPriceDiv ('salesPriceWithDiscount', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT', $product->prices);
	}

	echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
	echo $currency->createPriceDiv ('salesPriceTt', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_TT', $product->prices);
	//echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
	//echo $currency->createPriceDiv ('salesPriceQu', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $product->prices);
	if ($product->prices['discountedPriceWithoutTax'] != $product->prices['priceWithoutTax']) {
		echo $currency->createPriceDiv ('discountedPriceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $product->prices);
		echo $currency->createPriceDiv ('discountedPriceWithoutTaxTt', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX_TT', $product->prices);
	} else {
		echo $currency->createPriceDiv ('priceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $product->prices);
		echo $currency->createPriceDiv ('priceWithoutTaxTt', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX_TT', $product->prices);
	}
  echo $currency->createPriceDiv ('discountAmount', 'COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT', $product->prices);
	echo $currency->createPriceDiv ('discountAmountTt', 'COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT_TT', $product->prices);
	echo $currency->createPriceDiv ('taxAmount', 'COM_VIRTUEMART_PRODUCT_TAX_AMOUNT', $product->prices);
	echo $currency->createPriceDiv ('taxAmountTt', 'COM_VIRTUEMART_PRODUCT_TAX_AMOUNT_TT', $product->prices);
	$unitPriceDescription = vmText::sprintf ('COM_VIRTUEMART_PRODUCT_UNITPRICE', vmText::_('COM_VIRTUEMART_UNIT_SYMBOL_'.$product->product_unit));
	echo $currency->createPriceDiv ('unitPrice', $unitPriceDescription, $product->prices);
	}
	?>
</div>

