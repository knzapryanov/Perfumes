<div class="container">	<h2 style="text-align:center;">PAYMENT<BR/>TOTAL: €<span id="paymentTotal"></span></h2><BR/><BR/>	<div>		<ul class="nav nav-tabs">			<li class="active">				<a href="#newest">					<div class="tab_inside_main">						<div class="tab_inside_main_small_text">PAY WITH</div>						<div class="tab_inside_main_large_text"><span>CARD</span></div>						<div class="clearfix"></div>					</div>				</a>			</li>			<li>				<a href="#promotions">					<div class="tab_inside_main">						<div class="tab_inside_main_small_text">PAY WITH</div>						<div class="tab_inside_main_large_text"><span>PAYPAL ACCOUNT</span></div>						<div class="clearfix"></div>					</div>				</a>			</li>		</ul>	</div></div><div class="tab-content">		<div id="newest" class="tab-pane fade in active">		<div class="gallery">			<div class="container">				<!--<form method="POST" action="">					<h3>PAY WITH CARD</h3>					<div class="gallery-grids">												<div class="payment_details">							<div class="payment_card_number">								Card Number:<BR>								<input type="number" name="card_number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" min = "1" max = "9999999999999999"/> <img src="/images/maestro_card.png" /> <img src="/images/master_card.png" /> <img src="/images/visa_card.png" />							</div>														<div>								<div class="payment_exp_date">									Expiration Date:<BR>									<input type="number" name="mm" placeholder="MM" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" min = "1" max = "99"/> / <input type="number" name="mm" placeholder="YY" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" min = "1" max = "99"/>								</div>								<div class="payment_security_code">									Security code:<BR>									<input type="number" name="security_code" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" min = "1" max = "9999"/> <img src="/images/security_code.png" />								</div>																<div class="clearfix"></div>							</div>							<div class="payment_cardholder_name">								Cardholder Name:<BR>								<input type="text" name="first_name" placeholder="First Name"/> <input type="text" name="last_name" placeholder="Last Name"/>							</div>						</div>											</div><BR><BR>					<div class="confitm_order">						<input type="submit" value="PAY NOW" onclick="javascript:location.href='payment.php'" />						<div class="clearfix"></div>					</div>				</form>	-->
				<h3>PAY WITH CARD THROUGH PAYPAL</h3>				<div class="gallery-grids">					<div style="text-align:center;">
<form id="formPaypalCard" action="<?= base_url('payments') ?>" method="POST">							<input type="hidden" name="cmd" value="_cart" />							<input type="hidden" name="upload" value="1">							<input type="hidden" name="no_note" value="1" />							<input type="hidden" name="currency_code" value="EUR" />     <input type="hidden" name="notify_url" value="<?= base_url('payments')?>" /> <input type="hidden" name="cancel_return" value="<?= base_url('cancelPayment')?>" /> <input type="hidden" name="return" value="<?= base_url('successPayment')?>" /> <input type="hidden" name="address_override" value="1" /> 
    <input type="hidden" name="country" value="<?= $address['country'] ?>" />
    <input type="hidden" name="address1" value="<?= $address['street'] ?>" />
    <input type="hidden" name="city" value="<?= $address['city'] ?>" />
    <input type="hidden" name="email" value="<?= $address['email'] ?>" />
    <input type="hidden" name="first_name" value="<?= $address['first_name'] ?>" />
    <input type="hidden" name="last_name" value="<?= $address['last_name'] ?>" />
    <input type="hidden" name="zip" value="<?= $address['zip'] ?>" />
    <input type="hidden" name="night_phone_b" value="<?= $address['phone'] ?>" />
<input type="hidden" name="landing_page" value="Billing" />
<?php
 if($deliveryCost != 0) {
?>
    <input type="hidden" name="handling_cart" value="10" />
<?php
}
?>
	<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-rect-paypalcheckout-44px.png" name="submit" value="PAYMENT" />						</form>
</div></div>
		</div>		</div>	</div>	<div id="promotions" class="tab-pane fade">		<div class="gallery">			<div class="container">				<h3>PAY WITH PAYPAL ACCOUNT</h3>				<div class="gallery-grids">					<div style="text-align:center;">

						<form id="formPaypal" action="<?= base_url('payments') ?>" method="POST">							<input type="hidden" name="cmd" value="_cart" />							<input type="hidden" name="upload" value="1">							<input type="hidden" name="no_note" value="1" />							<input type="hidden" name="currency_code" value="EUR" />     <input type="hidden" name="notify_url" value="<?= base_url('payments')?>" /> <input type="hidden" name="cancel_return" value="<?= base_url('cancelPayment')?>" /> <input type="hidden" name="return" value="<?= base_url('successPayment')?>" /> <input type="hidden" name="address_override" value="1" /> 
    <input type="hidden" name="country" value="<?= $address['country'] ?>" />
    <input type="hidden" name="address1" value="<?= $address['street'] ?>" />
    <input type="hidden" name="city" value="<?= $address['city'] ?>" />
    <input type="hidden" name="email" value="<?= $address['email'] ?>" />
    <input type="hidden" name="first_name" value="<?= $address['first_name'] ?>" />
    <input type="hidden" name="last_name" value="<?= $address['last_name'] ?>" />
    <input type="hidden" name="zip" value="<?= $address['zip'] ?>" />
    <input type="hidden" name="night_phone_b" value="<?= $address['phone'] ?>" />
<?php
 if($deliveryCost != 0) {
?>
    <input type="hidden" name="handling_cart" value="10" />
<?php
}
?>
	<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" name="submit" value="PAYMENT" />						</form>
					</div>									</div>			</div>		</div>	</div></div><script>  function maxLengthCheck(object) {    if (object.value.length > object.max.length)      object.value = object.value.slice(0, object.max.length)  }      function isNumeric (evt) {    var theEvent = evt || window.event;    var key = theEvent.keyCode || theEvent.which;    key = String.fromCharCode (key);    var regex = /[0-9]|\./;    if ( !regex.test(key) ) {      theEvent.returnValue = false;      if(theEvent.preventDefault) theEvent.preventDefault();    }  }</script><script>$(document).ready(function(){    $(".nav-tabs a").click(function(){        $(this).tab('show');    });});</script><style>.targetDiv {display: none}</style><script>jQuery(function(){        jQuery('.showSingle').click(function(){              jQuery('.targetDiv').slideUp();              jQuery('.targetDiv').hide();              jQuery('#allproducts'+$(this).attr('target')).slideToggle();        });});</script>