<?php
	/*echo '<pre>';
	print_r($address);
	echo '</pre>';*/
?>
<div class="container">

	<?php if(isset($_SESSION['id'])): ?>
	<h2>Address</h2><BR/><BR/>

	<div class="shipping_information_table">

		<table>

			<tr>

				<td><i class="glyphicon glyphicon-user"></i></td>

				<td><?= $address['first_name']. ' ' . $address['last_name'] ?></td>

			</tr>

			<tr>

				<td valign="top"><i class="glyphicon glyphicon-map-marker"></i></td>

				<td>

					<span class="addreess"><?= $address['street'] ?></span><BR>

					<span class="city"><?= $address['city'] ?></span> <span class="postcode"><?= $address['zip'] ?></span><BR>

					<span class="country"><?= $address['country'] ?></span>

				</td>

			</tr>

			<tr>

				<td><i class="glyphicon glyphicon-envelope"></i></td>

				<td><?= $address['email'] ?></td>

			</tr>

			<tr>

				<td><i class="glyphicon glyphicon-phone"></i></td>

				<td><?= $address['phone'] ?></td>

			</tr>

			<tr>

				<td><i class="glyphicon glyphicon-pencil"></i></td>

				<td><a href="<?= base_url('profile') ?>">EDIT</a></td>

			</tr>

		</table>

	</div><!-- END address table -->
	<?php endif; ?>
	


	<?php if(!isset($_SESSION['id'])): ?>
	<div class="shipping_information_table" style="background:yello;">

		<input type="button" value="LOGIN / REGISTER" class="registerBtn"/>
		<input type="button" value="PAY AS GUEST" id="payAsGuestTab"/>

		<div class="clearfix"></div><BR><BR>



		<script>

			$(document).ready(function(){

				$("input[type='button']").click(function(){

					$(".show_shipping_info").show(1000);

				});

			});

		</script>



		<div class="show_shipping_info">

			<div class="shipping_info_names">

				<input type="text" name="first_name" placeholder="First Name" class="float_left" />

				<input type="text" name="lasst_name" placeholder="Last Name" class="float_right" />

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_street">

				<input type="text" name="street_address" placeholder="Enter your street address" class="full_width"/>

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_city_and_postcode">

				<input type="text" name="city" placeholder="City" class="float_left" />

				<input type="text" name="postcode" placeholder="Post code" class="float_right" />

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_email_and_mobile">

				<input type="text" name="mobile_number" placeholder="+35699805637" class="float_left" />

				<input type="email" name="email" placeholder="E-mail" class="float_right"/>

				<div class="clearfix"></div>

			</div>

		</div><BR/><BR/>

	</div><!-- END pay as guest table -->
	<?php endif; ?>




	<h2>ORDER CONFIRMATION</h2><BR/><BR/>
        
        <div class="confirm_products">
           
        </div>

		<!--
        <div id="paymentMethods">
            <div class="paymentCont">
                <input type="radio" name="payment" value="1" />
                <label class="labelP">Pay via Paypal</label>
            </div>
            <div class="paymentCont">
                <input type="radio"name="payment" value="2" />
                <label class="labelP">Pay via credit/debit cart through Paypal</label>
            </div>
        </div>
		-->

        <div class="confitm_order">

                    <div>Products Price: <span id="checkoutProductsPrice"></span></div>

                    <div>Delivery: <span id="checkoutDeliveryPrice"></span></div>

                    <div>Total: <span id="checkoutTotalPrice"></span></div><BR/>
                        
                    <input type="button" value="CONTINUE SHOPPING" id="continueShoppingBtn" /><BR/><BR/><BR/>
					<input type="button" value="PAYMENT" id="paymentBtn" /><BR/><BR/><BR/>
                    <div class="clearfix"></div>

	</div>
        
        
        	<!--paypal payment form
            <form id="formPaypal" action="<?= base_url('payments') ?>" method="POST">
                <input type="hidden" name="cmd" value="_cart" />
                <input type="hidden" name="upload" value="1">
		<input type="hidden" name="no_note" value="1" />
		<input type="hidden" name="currency_code" value="EUR" />
                
                <input type="submit" name="submit" value="PAYMENT" />
                
            </form>    
			-->


</div><!-- END container -->