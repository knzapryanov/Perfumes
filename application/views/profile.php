<div class="container">
    <h2>Profile Information</h2><BR/><BR/>
    
    <?php
    $flashdata = $this->session->flashdata('message');
    
    if($flashdata) :
    ?>
    
        <div id="flashDataMessage">
            
            <p><?= $flashdata ?></p>
            
        </div>
    
    <?php endif;?>
    
    <form action="<?= base_url('saveProfileInfo') ?>" method="POST" class="customStyle">
	<div class="shipping_information_table" >

		<input type="button" value="Address" class="address_container activeTab"/>
                <input type="button" value="Orders"  class="orders_container"/>

		<div class="clearfix"></div><BR><BR>


                <div id="address_container" class="effect_container show_shipping_info">

			<div class="shipping_info_names">

                            <input type="text" name="first_name" value="<?= $address['first_name'] ?>" placeholder="First Name" class="float_left" />

				<input type="text" name="last_name" value="<?= $address['last_name'] ?>" placeholder="Last Name" class="float_right" />

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_street">

				<input type="text" name="street_address" value="<?= $address['street'] ?>" placeholder="Enter your street address" class="full_width"/>

				<div class="clearfix"></div>

			</div>
                    
                         <div class="shipping_info_street">

				<input type="text" name="country" value="<?= $address['country'] ?>" placeholder="Enter your country" class="full_width"/>

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_city_and_postcode">

				<input type="text" name="city" value="<?= $address['city'] ?>" placeholder="City" class="float_left" />

				<input type="text" name="postcode" value="<?= $address['zip'] ?>" placeholder="Post code" class="float_right" />

				<div class="clearfix"></div>

			</div>

			<div class="shipping_info_email_and_mobile">

				<input type="text" name="mobile_number" value="<?= $address['phone'] ?>" placeholder="+35699805637" class="float_left" />

				<input type="email" name="email" value="<?= $address['email'] ?>" placeholder="E-mail" class="float_right"/>

				<div class="clearfix"></div>

			</div>

<!--			<div>

				<label><input type="checkbox" name="remember_shipping_information" class="remember_shipping_information" checked/> Remember this information</label>

			</div>-->


		</div><BR/><BR/>

	</div><!-- END shipping_information_table -->


        
	<div id="orders_container" class="effect_container" style="display:none">

		<div class="confirm_products_single">

			<div class="confirm_order_single_pr_number float_left">#: <b>1</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_image float_left"><img src="/images/g1.png"><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_name float_left">PRODDUCT: <b><span>Bulgari Omnia pink</span></b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_ml float_left">ML: <b>30ml</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_quantity float_left">QUANTITY: <b>2</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_singlr_price float_left">SINGLE PRICE: <b>€55</b></div>

			<div class="clearfix"></div>

		</div>



		<div class="confirm_products_single">

			<div class="confirm_order_single_pr_number float_left">#: <b>2</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_image float_left"><img src="/images/g1.png"><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_name float_left">PRODDUCT: <b><span>Bulgari Omnia pink</span></b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_ml float_left">ML: <b>30ml</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_quantity float_left">QUANTITY: <b>2</b><span class="devider_vertical_line">|</span></div>

			<div class="confirm_order_single_pr_singlr_price float_left">SINGLE PRICE: <b>€55</b></div>

			<div class="clearfix"></div>

		</div>



	</div>	
        
      <input type="submit" value="Save" name="saveProfile"  class="save_profile_info"/>
     </form>   

</div><!-- END container -->