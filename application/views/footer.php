<!--subscribe-->

<div class="subscribe">

	<div class="container">

		<div class="subscribe1">

			<h4>the latest from Perfumes Malta</h4>

		</div>

		<div class="subscribe2">

			<form id="emailSubscription" action="javascript:void(0);" method="POST">

				<input
					id="subscriptionInput"
					type="text"
					required
					type="email"
					class="text"
					name="sign_email"
					placeholder="Email..."
					autocomplete="off"
				>

				<input id="submitEmail" type="submit" value="JOIN">

			</form>

		</div>

		<div class="clearfix"></div>

	</div>

</div>

<div id="dialog" title="Alert message" style="display: none">
	<div class="ui-dialog-content ui-widget-content">
		<p>
			<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>
			<label id="lblMessage">
			</label>
		</p>
	</div>
</div>

<!--subscribe-->

<!--footer-->

<div class="footer-section">

	<div class="container">

		<div class="footer-grids">

			<div class="col-md-2 footer-grid">

			<h4>company</h4>

			<ul>

				<li><a href="products.php">products</a></li>

				<li><a href="#">Team</a></li>

				<li><a href="#">Sitemap</a></li>

			</ul>

		</div>

			<div class="col-md-2 footer-grid">

			<h4>service</h4>

			<ul>

				<li><a href="#">Support</a></li>

				<li><a href="#">FAQ</a></li>

				<li><a href="#">Warranty</a></li>

				<li><a href="contact.php">Contact Us</a></li>

			</ul>

			</div>

			<div class="col-md-2 footer-grid">

			<h4>order & returns</h4>

			<ul>

				<li><a href="#">Order Status</a></li>

				<li><a href="#">Shipping Policy</a></li>

				<li><a href="#">Return Policy</a></li>

				<li><a href="#">Digital Gift Card</a></li>

			</ul>

			</div>

			<div class="col-md-2 footer-grid">

			<h4>legal</h4>

			<ul>

				<li><a href="#">Privacy</a></li>

				<li><a href="#">Terms and Conditions</a></li>

				<li><a href="#">Social Responsibility</a></li>

			</ul>

			</div>

			<div class="col-md-4 footer-grid1">

			<div class="social-icons">

				<a href="#"><i class="icon1"></i></a>

				<a href="#"><i class="icon2"></i></a>

			</div>

			<p>Copyright &copy; 2016 Perfumes Malta. All rights reserved</p>

			</div>

		<div class="clearfix"></div>

		</div>

	</div>

</div>

<!--footer-->

		



<form id="all_brands" name="all_brands" action="" method="">

	<div id="light" class="white_content">

		<div class="terms_close">
			<a id="searchBrands" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">CLOSE X</a>
		</div>

	

		<div class="terms_content">

		

			<div>
                            <?php foreach ($brands as $brand) : ?>
                              <div class="all_brands_column">
                                 <label><input type="checkbox" value="<?= $brand->id ?>" name="checkbox"><i></i> <?= $brand->brand_name ?></label>
                              </div>
                            <?php endforeach;  ?>

                            <div style="clear:both;"></div>

			</div>	

		

		</div><!-- END of TERMS_CONTENT  -->



		<div class="terms_search">

			<a attr-cat="" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="button searchOverlyBrands">SEARCH</a>

		</div>

	</div><!-- END of WHITE CONTENT  -->

</form>





<div id="fade" class="black_overlay"></div>







</body>

</html>