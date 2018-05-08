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
//var_dump($type_of_product);
if($viewData['orderable']) {
    
    if($type_of_product == 1){
        echo '<input type="submit" name="addtocart" id="addtocartbtn" class="addtocart-button" value="'.vmText::_( 'Copy robot' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" />';
    }elseif(FxbotmarketProduct::ifDownloadableTypeOfProduct ($type_of_product)){
        echo '<input type="submit" name="addtocart" id="addtocartbtn" class="addtocart-button" value="'.vmText::_( 'Order now' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" />';
    }elseif(FxbotmarketProduct::ifEaTypeOfProduct ($type_of_product)){
        if(is_object($fx_product) && isset($fx_product->id_product) && $fx_product->id_product > 0){
            echo '<input type="hidden" name="fx_product_rent" id="fx_product_rent" value="0" >';
            echo '<input type="hidden" name="fx_product_demo" id="fx_product_demo" value="0" >';
            echo '<input type="hidden" name="fx_product_trial" id="fx_product_trial" value="0" >';
            if($fx_product->price > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" id="addtocartbtn" onclick="jQuery(\'#fx_product_rent\').val(100); jQuery(\'#fx_product_trial\').val(0);jQuery(\'#fx_product_demo\').val(0); " class="addtocart-button fxbuybtn" value="'.vmText::_( 'Buy:  '.FxbotmarketProduct::formatMoney($fx_product->price, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> '
                . '</div>';
            }
            if($fx_product->rent1 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(1);jQuery(\'#fx_product_trial\').val(0);jQuery(\'#fx_product_demo\').val(0); " id="addtocartbtn1" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 1 month:  '.FxbotmarketProduct::formatMoney($fx_product->rent1, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent3 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(3);jQuery(\'#fx_product_trial\').val(0);jQuery(\'#fx_product_demo\').val(0);" id="addtocartbtn3" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 3 monthes:  '.FxbotmarketProduct::formatMoney($fx_product->rent3, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent6 > 0){
                echo '<div class="fx_product_price" >'
                . '<input onclick="jQuery(\'#fx_product_rent\').val(6);jQuery(\'#fx_product_trial\').val(0);jQuery(\'#fx_product_demo\').val(0);" type="submit" name="addtocart" id="addtocartbtn6" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 6 monthes:  '.FxbotmarketProduct::formatMoney($fx_product->rent6, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            if($fx_product->rent12 > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_rent\').val(12);jQuery(\'#fx_product_trial\').val(0);jQuery(\'#fx_product_demo\').val(0);" id="addtocartbtn12" class="addtocart-button fxrentbtn" value="'.vmText::_( 'Rent for 1 year:  '.FxbotmarketProduct::formatMoney($fx_product->rent12, 2, 'USD') ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" /> </div>';
            }
            $demo_file = FxbotmarketProduct::getDemoFile($fx_product->id_product);
            if($demo_file){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_demo\').val('.(int)$demo_file->id_product.');jQuery(\'#fx_product_trial\').val(0);" '
                . 'id="addtocartbtndemo" class="addtocart-button fxdemobtn" value="'.vmText::_( 'Free demo  ').'" title="'.vmText::_( 'Try demo first' ).'" /> '
                . '</div>';
            }
            //$trial_file = FxbotmarketProduct::getTrialFile($fx_product->id_product);
            if($fx_product->trial_period > 0){
                echo '<div class="fx_product_price" >'
                . '<input type="submit" name="addtocart" onclick="jQuery(\'#fx_product_trial\').val('.$fx_product->id_product.');jQuery(\'#fx_product_demo\').val(0);" '
                . 'id="addtocartbtndemo" class="addtocart-button fxdemobtn" value="'.vmText::_( 'Download Trial ').'" title="'.vmText::_( 'Try Trial first' ).'" /> '
                . '</div>';
            }
        }
    }elseif($type_of_product == 1001){
        
          if(true){
                        $app = JFactory::getApplication();
                        $input = $app->input;
                        $blockpad_source = $input->get('blockpad_source',0,'int');    
                        $blockpad_register = $input->post->get('blockpad_register',0,'int');  
                        if(($blockpad_source == 1 || $blockpad_register == 1) && $user_id <= 0)  {
                                ?>
                <p><input name="fxbregisterselected" value="1" id="creditid"  onclick="displayPanel(1);" type="radio" checked="checked"> I want Register</p>
                <h4 style="color:red;">OR</h4>
                <p><input name="fxbregisterselected" value="2" id="paypalid" onclick="displayPanel(0);" type="radio" > I want Login</p>
                 <input type="hidden" name="blockpad_register" value="1">
                <div id="fxblogpanel" style="display: none;">
                    <div class="form-group">
                        
                        <input title="" placeholder="Username..." value="" data-validation="required server"
                               data-validation-url="/accounts/register-new-user?task=registration.ajaxCheckUserName&amp;format=json"
                               data-validation-error-msg="Your username is required" id="jform_username"
                               name="fxblogin" maxlength="200" size="40" class="" type="text" style="float:none;">
		</div>                                                                 
                

                
                <div class="form-group has-error">
                    <input title="" placeholder="Password..." value="" name="fxbloginpassword1" 
                           data-validation="required strength" data-validation-strength="1" 
                           id="jform_password1" maxlength="200" size="40" class="error"
                           autocomplete="off" style="float:none;width:100%;height:45px;" 
                           data-validation-has-keyup-event="true" type="password">
                    
                </div>
                </div>
                
                <div id="fxbregpanel" >
                <div class="form-group has-error">
                       
                        <input title="" placeholder="Name..." value="" data-validation="length" 
                               data-validation-length="min3" 
                               data-validation-error-msg="Your name is too short!" 
                               id="jform_name" name="fxbname" maxlength="200" size="40" 
                               class="error" style="float:none;" data-validation-has-keyup-event="true" type="text">
			
                </div>
                <div class="form-group">
                        
                        <input title="" placeholder="Username..." value="" data-validation="required server"
                               data-validation-url="/accounts/register-new-user?task=registration.ajaxCheckUserName&amp;format=json"
                               data-validation-error-msg="Your username is required" id="jform_username"
                               name="fxbusername" maxlength="200" size="40" class="" type="text" style="float:none;">
		</div>                                                                 
                
                <div class="form-group">
                   
                    <input title="" placeholder="Email..." value="" 
                           data-validation="email server" 
                           data-validation-url="/accounts/register-new-user?task=registration.ajaxCheckEmail&amp;format=json" 
                           id="jform_email1" name="fxbemail1" maxlength="200" size="40"  style="float:none;"
                           class="required"
                           type="text">
		</div>
                
                <div class="form-group has-error">
                    <input title="" placeholder="Password..." value="" name="fxbpassword1" 
                           data-validation="required strength" data-validation-strength="1" 
                           id="jform_password1" maxlength="200" size="40" class="error"
                           autocomplete="off" style="float:none;width:100%;height:45px;" 
                           data-validation-has-keyup-event="true" type="password">
                    
                </div>
                
                <div class="form-group has-error">
                  
                    <input title="" placeholder="Mobile Phone..." value="" data-validation="required" 
                           data-validation-error-msg="is required. Make sure it contains a valid value!" 
                           id="jform_cf_phone" name="fxbcf_phone" maxlength="200" size="40" class="error" 
                           style="float:none;" data-validation-has-keyup-event="true"
                           type="text">

                </div>
               
                <div class="form-group">

										<label id="lblfield-1" for="jform_cf_country" class="sr-only">*Country</label>

                <select id="fxbotmarket_country_id_field" name="fxbcountry_id" class="fxbotmarket-select required fxbotmarket-select form-control" style="width: 100%;height:45px;"  aria-required="true" required="required">
                        <option value="" selected="selected">-- Select country --</option>
                        <option value="1">Afghanistan</option>
                        <option value="2">Albania</option>
                        <option value="3">Algeria</option>
                        <option value="4">American Samoa</option>
                        <option value="5">Andorra</option>
                        <option value="6">Angola</option>
                        <option value="7">Anguilla</option>
                        <option value="8">Antarctica</option>
                        <option value="9">Antigua and Barbuda</option>
                        <option value="10">Argentina</option>
                        <option value="11">Armenia</option>
                        <option value="12">Aruba</option>
                        <option value="13">Australia</option>
                        <option value="14">Austria</option>
                        <option value="15">Azerbaijan</option>
                        <option value="16">Bahamas</option>
                        <option value="17">Bahrain</option>
                        <option value="18">Bangladesh</option>
                        <option value="19">Barbados</option>
                        <option value="20">Belarus</option>
                        <option value="21">Belgium</option>
                        <option value="22">Belize</option>
                        <option value="23">Benin</option>
                        <option value="24">Bermuda</option>
                        <option value="25">Bhutan</option>
                        <option value="26">Bolivia</option>
                        <option value="243">Bonaire, Sint Eustatius and Saba</option>
                        <option value="27">Bosnia and Herzegovina</option>
                        <option value="28">Botswana</option>
                        <option value="29">Bouvet Island</option>
                        <option value="30">Brazil</option>
                        <option value="31">British Indian Ocean Territory</option>
                        <option value="32">Brunei Darussalam</option>
                        <option value="33">Bulgaria</option>
                        <option value="34">Burkina Faso</option>
                        <option value="35">Burundi</option>
                        <option value="36">Cambodia</option>
                        <option value="37">Cameroon</option>
                        <option value="38">Canada</option>
                        <option value="244">Canary Islands</option>
                        <option value="39">Cape Verde</option>
                        <option value="40">Cayman Islands</option>
                        <option value="41">Central African Republic</option>
                        <option value="42">Chad</option>
                        <option value="43">Chile</option>
                        <option value="44">China</option>
                        <option value="45">Christmas Island</option>
                        <option value="46">Cocos (Keeling) Islands</option>
                        <option value="47">Colombia</option>
                        <option value="48">Comoros</option>
                        <option value="49">Congo, Republic of the</option>
                        <option value="50">Cook Islands</option>
                        <option value="51">Costa Rica</option>
                        <option value="53">Croatia</option>
                        <option value="54">Cuba</option>
                        <option value="55">Cyprus</option>
                        <option value="56">Czech Republic</option>
                        <option value="52">Côte d'Ivoire</option>
                        <option value="57">Denmark</option>
                        <option value="58">Djibouti</option>
                        <option value="59">Dominica</option>
                        <option value="60">Dominican Republic</option>
                        <option value="62">Ecuador</option>
                        <option value="63">Egypt</option>
                        <option value="64">El Salvador</option>
                        <option value="65">Equatorial Guinea</option>
                        <option value="66">Eritrea</option>
                        <option value="67">Estonia</option>
                        <option value="68">Ethiopia</option>
                        <option value="69">Falkland Islands (Malvinas)</option>
                        <option value="70">Faroe Islands</option>
                        <option value="71">Fiji</option>
                        <option value="72">Finland</option>
                        <option value="73">France</option>
                        <option value="75">French Guiana</option>
                        <option value="76">French Polynesia</option>
                        <option value="77">French Southern Territories</option>
                        <option value="78">Gabon</option>
                        <option value="79">Gambia</option>
                        <option value="80">Georgia</option>
                        <option value="81">Germany</option>
                        <option value="82">Ghana</option>
                        <option value="83">Gibraltar</option>
                        <option value="84">Greece</option>
                        <option value="85">Greenland</option>
                        <option value="86">Grenada</option>
                        <option value="87">Guadeloupe</option>
                        <option value="88">Guam</option>
                        <option value="89">Guatemala</option>
                        <option value="90">Guinea</option>
                        <option value="91">Guinea-Bissau</option>
                        <option value="92">Guyana</option>
                        <option value="93">Haiti</option>
                        <option value="94">Heard and McDonald Islands</option>
                        <option value="95">Honduras</option>
                        <option value="96">Hong Kong</option>
                        <option value="97">Hungary</option>
                        <option value="98">Iceland</option>
                        <option value="99">India</option>
                        <option value="100">Indonesia</option>
                        <option value="101">Iran, Islamic Republic of</option>
                        <option value="102">Iraq</option>
                        <option value="103">Ireland</option>
                        <option value="104">Israel</option>
                        <option value="105">Italy</option>
                        <option value="106">Jamaica</option>
                        <option value="107">Japan</option>
                        <option value="241">Jersey</option>
                        <option value="108">Jordan</option>
                        <option value="109">Kazakhstan</option>
                        <option value="110">Kenya</option>
                        <option value="111">Kiribati</option>
                        <option value="112">Korea, Democratic People's Republic of</option>
                        <option value="113">Korea, Republic of</option>
                        <option value="114">Kuwait</option>
                        <option value="115">Kyrgyzstan</option>
                        <option value="116">Lao People's Democratic Republic</option>
                        <option value="117">Latvia</option>
                        <option value="118">Lebanon</option>
                        <option value="119">Lesotho</option>
                        <option value="120">Liberia</option>
                        <option value="121">Libya</option>
                        <option value="122">Liechtenstein</option>
                        <option value="123">Lithuania</option>
                        <option value="124">Luxembourg</option>
                        <option value="125">Macau</option>
                        <option value="126">Macedonia, the former Yugoslav Republic of</option>
                        <option value="127">Madagascar</option>
                        <option value="128">Malawi</option>
                        <option value="129">Malaysia</option>
                        <option value="130">Maldives</option>
                        <option value="131">Mali</option>
                        <option value="132">Malta</option>
                        <option value="133">Marshall Islands</option>
                        <option value="134">Martinique</option>
                        <option value="135">Mauritania</option>
                        <option value="136">Mauritius</option>
                        <option value="137">Mayotte</option>
                        <option value="138">Mexico</option>
                        <option value="139">Micronesia, Federated States of</option>
                        <option value="140">Moldova, Republic of</option>
                        <option value="141">Monaco</option>
                        <option value="142">Mongolia</option>
                        <option value="143">Montserrat</option>
                        <option value="144">Morocco</option>
                        <option value="145">Mozambique</option>
                        <option value="146">Myanmar</option>
                        <option value="147">Namibia</option>
                        <option value="148">Nauru</option>
                        <option value="149">Nepal</option>
                        <option value="150">Netherlands</option>
                        <option value="151">Netherlands Antilles</option>
                        <option value="152">New Caledonia</option>
                        <option value="153">New Zealand</option>
                        <option value="154">Nicaragua</option>
                        <option value="155">Niger</option>
                        <option value="156">Nigeria</option>
                        <option value="157">Niue</option>
                        <option value="158">Norfolk Island</option>
                        <option value="159">Northern Mariana Islands</option>
                        <option value="160">Norway</option>
                        <option value="161">Oman</option>
                        <option value="162">Pakistan</option>
                        <option value="163">Palau</option>
                        <option value="248">Palestinian Territory, Occupied</option>
                        <option value="164">Panama</option>
                        <option value="165">Papua New Guinea</option>
                        <option value="166">Paraguay</option>
                        <option value="167">Peru</option>
                        <option value="168">Philippines</option>
                        <option value="169">Pitcairn</option>
                        <option value="170">Poland</option>
                        <option value="171">Portugal</option>
                        <option value="172">Puerto Rico</option>
                        <option value="173">Qatar</option>
                        <option value="175">Romania</option>
                        <option value="176">Russian Federation</option>
                        <option value="177">Rwanda</option>
                        <option value="174">Réunion</option>
                        <option value="242">Saint Barthélemy</option>
                        <option value="197">Saint Helena</option>
                        <option value="178">Saint Kitts and Nevis</option>
                        <option value="179">Saint Lucia</option>
                        <option value="246">Saint Martin (French part)</option>
                        <option value="198">Saint Pierre and Miquelon</option>
                        <option value="180">Saint Vincent and the Grenadines</option>
                        <option value="181">Samoa</option>
                        <option value="182">San Marino</option>
                        <option value="183">Sao Tome And Principe</option>
                        <option value="184">Saudi Arabia</option>
                        <option value="185">Senegal</option>
                        <option value="245">Serbia</option>
                        <option value="186">Seychelles</option>
                        <option value="187">Sierra Leone</option>
                        <option value="188">Singapore</option>
                        <option value="247">Sint Maarten (Dutch part)</option>
                        <option value="189">Slovakia</option>
                        <option value="190">Slovenia</option>
                        <option value="191">Solomon Islands</option>
                        <option value="192">Somalia</option>
                        <option value="193">South Africa</option>
                        <option value="194">South Georgia and the South Sandwich Islands</option>
                        <option value="195">Spain</option>
                        <option value="196">Sri Lanka</option>
                        <option value="199">Sudan</option>
                        <option value="200">Suriname</option>
                        <option value="201">Svalbard and Jan Mayen</option>
                        <option value="202">Swaziland</option>
                        <option value="203">Sweden</option>
                        <option value="204">Switzerland</option>
                        <option value="205">Syrian Arab Republic</option>
                        <option value="206">Taiwan</option>
                        <option value="207">Tajikistan</option>
                        <option value="208">Tanzania, United Republic of</option>
                        <option value="209">Thailand</option>
                        <option value="237">The Democratic Republic of Congo</option>
                        <option value="61">Timor-Leste</option>
                        <option value="210">Togo</option>
                        <option value="211">Tokelau</option>
                        <option value="212">Tonga</option>
                        <option value="213">Trinidad and Tobago</option>
                        <option value="214">Tunisia</option>
                        <option value="215">Turkey</option>
                        <option value="216">Turkmenistan</option>
                        <option value="217">Turks and Caicos Islands</option>
                        <option value="218">Tuvalu</option>
                        <option value="219">Uganda</option>
                        <option value="220">Ukraine</option>
                        <option value="221">United Arab Emirates</option>
                        <option value="222">United Kingdom</option>
                        <option value="223">United States</option>
                        <option value="224">United States Minor Outlying Islands</option>
                        <option value="225">Uruguay</option>
                        <option value="226">Uzbekistan</option>
                        <option value="227">Vanuatu</option>
                        <option value="228">Vatican City State (Holy See)</option>
                        <option value="229">Venezuela</option>
                        <option value="230">Viet Nam</option>
                        <option value="231">Virgin Islands, British</option>
                        <option value="232">Virgin Islands, U.S.</option>
                        <option value="233">Wallis and Futuna</option>
                        <option value="234">Western Sahara</option>
                        <option value="235">Yemen</option>
                        <option value="238">Zambia</option>
                        <option value="239">Zimbabwe</option>
                </select>
										
</div>
                </div>                
                
                
                                                                                
                <?php
                        }          
                            
                ?>
                
                
              
            
                        <?php } 
        
        
        echo '<input type="submit" name="addtocart" id="addtocartbtn" class="addtocart-button" value="'.vmText::_( 'Order blockpad' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" />';
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
    function displayPanel(arg){
                    if(arg == 1){
                      jQuery('#fxbregpanel').show();
                      jQuery('#fxblogpanel').hide();
                    }else{
                      jQuery('#fxblogpanel').show();
                      jQuery('#fxbregpanel').hide();
                    }
                }
</script>