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
$fxproduct = $viewData['fxproduct'];
$monthly_flat_fee =  $viewData['monthly_flat_fee'];
$type_of_product = $fxproduct->typeofproduct;
//var_dump($type_of_product);
$virtuemart_product_id = $product->virtuemart_product_id;
$currency = '$';//$viewData['currency'];
if(!class_exists('FxbotmarketProduct')) {
  include_once JPATH_ROOT.'/components/com_fxbotmarket/helpers/product.php';
}
//find type of product
$base_price = $product->prices['basePrice'];
if($type_of_product == 1){//only for signal products we need to add
    //monthly flat fee
    
    if( is_array($product->prices)){
        $product->prices = FxbotmarketProduct::addPaypalMonthlyFee($product->prices,$monthly_flat_fee);
    }
}
/*
$currency_model = VmModel::getModel('currency');
	$displayCurrency = $currency_model->getCurrency( $product->allPrices['product_currency'] );
	$currency = $displayCurrency->currency_symbol;
*/
        
if($type_of_product == 1){//only for signal products we need to add
?>


<?php
	
	//$currency.' '.$first_col.'.00'
	$first_col = FxbotmarketProduct::formatMoney($base_price, 0, $currency.' ' ); //$currency.' '.$base_price.'.00';
	$sec_col = FxbotmarketProduct::formatMoney($monthly_flat_fee, 0, $currency.' ' );//$currency.' '.$monthly_flat_fee.'.00';
	$third_col = FxbotmarketProduct::formatMoney($product->prices['basePrice'], 0, $currency.' ' );//$currency.' '.$product->prices['basePrice'].'.00';
        $first_label = 'Price';
        $sec_label = 'Copy bot';
        $third_label = 'Total';
        ?>
    
	

<!-- <div class="product-price test22" id="productPrice<?php //echo $product->virtuemart_product_id ?>"> -->
	<?php
}elseif(FxbotmarketProduct::ifEaTypeOfProduct($type_of_product)){
    $first_label = 'Price';
        $sec_label = 'Demo';
        $third_label = 'Rent';
        $first_col = FxbotmarketProduct::formatMoney($product->prices['basePrice'], 0, $currency.' ' );//$currency.' '.$product->prices['basePrice'];
        if($fxproduct->demo_id > 0){
            $sec_col = 'yes';
        }else{
            $sec_col = 'no';
        }
        if($fxproduct->rent1 > 0 || $fxproduct->rent3 > 0 ||$fxproduct->rent6 > 0 || $fxproduct->rent12 > 0 ){
//a.rent1,' 'a.rent3,a.rent6,a.rent12,b.id as demo_id
            $third_col = 'yes';
        }else{
            $third_col = 'no';
        }
	
}elseif(FxbotmarketProduct::ifDownloadableTypeOfProduct($type_of_product)){
    $first_label = 'Price';
        $sec_label = 'Demo';
        $third_label = 'Trial';
        $first_col = FxbotmarketProduct::formatMoney($product->prices['basePrice'], 0, $currency.' ' );//$currency.' '.$product->prices['basePrice'].'.00';
        if($fxproduct->demo_id > 0){
            $sec_col = 'yes';
        }else{
            $sec_col = 'no';
        }
        if($fxproduct->trial_period > 0 ){
//a.rent1,' 'a.rent3,a.rent6,a.rent12,b.id as demo_id
            $third_col = 'yes';
        }else{
            $third_col = 'no';
        }
}
    ?>
<div class="marketplace-wid-sale">
<div class="marketplace-sale-col"><img src="/images/base-price.png"> <h5><?php echo $first_label; ?></h5> <p><?php echo $first_col; ?></p></div>
	<div class="marketplace-sale-col"><img src="/images/sale-price.png"> <h5><?php echo $sec_label; ?></h5> <p><?php echo $sec_col; ?></p></div>
	<div class="marketplace-sale-col"><img src="/images/taxfree-price.png"> <h5><?php echo $third_label; ?></h5> <p><?php echo $third_col; ?></p></div>
	
</div>   
<?php
	
        if($fxproduct->typeofproduct == 1 && false){
	?>
 

<div class="vm-details-button">
	<a href="<?php 
        echo JURI::root(); ?>taps?product=<?php echo $product->virtuemart_product_id; ?>" class="product-details">
            Tap Statistics</a>
</div>

<?php

        }else{
        ?>
<div class="vm-details-button" style="height:59px;">
	
</div>
        <?php } ?>
