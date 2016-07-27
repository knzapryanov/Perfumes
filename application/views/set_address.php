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

				<td><?php echo '<span class="tableInformation" name="first_name" id="firstName_table">'.$address['first_name']. '</span> <span name="last_name" class="tableInformation" id="lastName_table">' . $address['last_name'].'</span>' ?></td>

			</tr>

			<tr>

				<td valign="top"><i class="glyphicon glyphicon-map-marker"></i></td>

				<td>

					<span name="street" class="addreess tableInformation"><?= $address['street'] ?></span><BR>

					<span name="city" class="city tableInformation"><?= $address['city'] ?></span> <span class="postcode"><?= $address['zip'] ?></span><BR>

					<span name="country" class="country tableInformation"><?= $address['country'] ?></span>

				</td>

			</tr>

			<tr>

				<td><i class="glyphicon glyphicon-envelope"></i></td>

				<td><?php echo '<span name="email" class="tableInformation" id="emailName_table">'.$address['email'].'</span>' ?></td>

			</tr>

			<tr>

				<td><i class="glyphicon glyphicon-phone"></i></td>

				<td class="tableInformation"><?= $address['phone'] ?></td>

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

        <form action="<?= base_url('payment')?>" id="goToPaymentsForm" method="POST">    
            <div class="confitm_order">
                <input type="hidden" name="token" value="<?= $token; ?>" />        
                <div>Products Price: <span id="checkoutProductsPrice"></span></div>

                <div>Delivery: <span id="checkoutDeliveryPrice"></span></div>

                <div>Total: <span id="checkoutTotalPrice"></span></div><BR/>

                <input type="button" value="CONTINUE SHOPPING" id="continueShoppingBtn" /><BR/><BR/><BR/>
                <input type="submit" value="PAYMENT" id="paymentBtn" /><BR/><BR/><BR/>
                <div class="clearfix"></div>

            </div>
       </form>     


</div><!-- END container -->