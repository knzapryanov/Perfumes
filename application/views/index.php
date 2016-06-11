<div class="banner-section" style="margin:0 0 20px 0;">

	<div class="container">

		<div class="banner-grids">

			<div class="col-md-6 banner-grid">

				<h2>The Lates Perfumes</h2>

				<p>Wellcome to our perfumes shop. Here you can find the biggest collection of all original perfumes you need ! We can offer you the lowest prices and over 1500 perfumes.</p>

				<a href="products.php" class="button"> shop now </a>

			</div>

			<div class="col-md-6 banner-grid1">

                            <img src="<?= base_url('assets/images/p2.png') ?>" class="img-responsive" alt=""/>

			</div>

			<div class="clearfix"></div>

		</div>

	</div>

</div>





<div class="container">

	<div>

		<ul class="nav nav-tabs">

			<li class="active">

				<a href="#newest">

					<div class="tab_inside_main">

						<div class="tab_inside_main_small_text">SEE</div>

						<div class="tab_inside_main_large_text"><span>NEWEST</span></div>

						<div class="clearfix"></div>

					</div>

				</a>

			</li>

			<li>

				<a href="#promotions">

					<div class="tab_inside_main">

						<div class="tab_inside_main_small_text">SEE</div>

						<div class="tab_inside_main_large_text"><span>PROMOTIONS</span></div>

						<div class="clearfix"></div>

					</div>

				</a>

			</li>

		</ul>

	</div>

</div>



<div class="tab-content">

	

	<div id="newest" class="tab-pane fade in active">
		<div class="gallery">

			<div class="container">

				<h3>NEWEST</h3>

				<div class="gallery-grids">
                                    
                                        <?php foreach($manualNewest as $product) : ?>   
                                      	<div class="col-md-3 gallery-grid ">
                                            <a href="<?= base_url('product').'/'.$product->id ?>">
                                                        <?php
                                                        
                                                        $salePrice = array();
                                                        $percentage = array();
                                                        $price = array();
                                                        $minSalePrice = array();
                                                        
                                                        foreach ($product->options as $option) {
                                                               $price[] = $option->price;
                                                               $salePrice[] = $option->sale_price;
                                                               
                                                               if((int)$option->sale_price !== 0) {
                                                                   $minSalePrice[] = $option->sale_price;
                                                               }
                                                               
                                                               $percentage[] = $option->off_percentage;
                                                        }
                                                        
                                                        $maxSale = (int)max($salePrice);
                                                        $minSale = count($minSalePrice) > 0 ? (int)min($minSalePrice) : '';
                                                        $maxpercentage = (int)max($percentage);
                                                        
                                                        ?>
                                                        
                                                        
                                                        <?php if($maxSale > 0) : ?>
                                                           <?php if($maxpercentage >= 30) : ?>
                                                
                                                                <div class="b-wrapper_sale">
                                                                        <div>SALE</div>
                                                                </div>
                                                               
                                                           <?php else :?>     
                                                                 <div class="b-wrapper_percent_off">
                                                                        <div><?= $maxpercentage ?>%<BR/>OFF</div>
                                                                </div>
                                                            <?php endif; ?>    
                                                        <?php endif; ?>    
                                                <?php 
                                                             
                                                
                                                ?>
                                                <img src="<?= base_url('assets/uploads/thumbs').'/'.$product->pictures[0]->source ?>" class="img-responsive" alt="<?= $product->product_name ?>" />
							<div class="gallery-info">
								<div class="quick">
									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>
								</div>
							</div>
						</a>
						<div class="galy-info">
							<p><?= $product->product_name ?></p>
							<div class="galry">
                                                                <?php if($maxSale > 0) : ?>
                                                                    <div class="home_item_price"><del>€<?= min($price);  ?>.00</del></div>
                                                                    <div class="home_new_price">€<?= $minSale;  ?>.00</div>						
                                                                <?php else : ?>
                                                                    <div class="home_item_price">€<?= min($price);  ?>.00</div>
                                                                <?php endif; ?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
			
                                        <?php endforeach; ?>
                                        
					<div class="clearfix"></div>
                                        
					</div>
                                <!-- END GALLERY -->

					<div style="text-align:center;"><a class="showSingle button" target="1">See all newest products</a></div>

				</div>

			</div>

		</div>

















	<div id="promotions" class="tab-pane fade">











		<div class="gallery">

			<div class="container">

				<h3>PROMOTIONS</h3>

				<div class="gallery-grids">



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid ">

						<a href="products.php">



							<div class="b-wrapper_percent_off">

								<div>-20%<BR/>OFF</div>

							</div>

							

							<img src="images/g1.png" class="img-responsive" alt="" />

							

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari Omnia</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->



					<div class="col-md-3 gallery-grid">

						<a href="products.php">

							

							<div class="b-wrapper_sale">

								<div>SALE</div>

							</div>



							<img src="images/g2.png" class="img-responsive" alt=""/>

							<div class="gallery-info">

								<div class="quick">

									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

								</div>

							</div>

						</a>

						<div class="galy-info">

							<p>Bvlgari In Black</p>

							<div class="galry">

								<div class="home_item_price"><del>€100.00</del></div>

								<div class="home_new_price">€95.00</div>						

								<div class="clearfix"></div>

							</div>

						</div>

					</div><!-- END of ITEM -->

				

					<div class="clearfix"></div>



					<div id="allproducts2" class="targetDiv">

						

						<div class="col-md-3 gallery-grid ">

							<a href="products.php">



								<div class="b-wrapper_percent_off">

									<div>-20%<BR/>OFF</div>

								</div>

								

								<img src="images/g1.png" class="img-responsive" alt="" />

								

								<div class="gallery-info">

									<div class="quick">

										<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

									</div>

								</div>

							</a>

							<div class="galy-info">

								<p>Bvlgari Omnia</p>

								<div class="galry">

									<div class="home_item_price"><del>€100.00</del></div>

									<div class="home_new_price">€95.00</div>						

									<div class="clearfix"></div>

								</div>

							</div>

						</div><!-- END of ITEM -->



						<div class="col-md-3 gallery-grid">

							<a href="products.php">

								

								<div class="b-wrapper_sale">

									<div>SALE</div>

								</div>



								<img src="images/g2.png" class="img-responsive" alt=""/>

								<div class="gallery-info">

									<div class="quick">

										<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

									</div>

								</div>

							</a>

							<div class="galy-info">

								<p>Bvlgari In Black</p>

								<div class="galry">

									<div class="home_item_price"><del>€100.00</del></div>

									<div class="home_new_price">€95.00</div>						

									<div class="clearfix"></div>

								</div>

							</div>

						</div><!-- END of ITEM -->



						<div class="col-md-3 gallery-grid ">

							<a href="products.php">



								<div class="b-wrapper_percent_off">

									<div>-20%<BR/>OFF</div>

								</div>

								

								<img src="images/g1.png" class="img-responsive" alt="" />

								

								<div class="gallery-info">

									<div class="quick">

										<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

									</div>

								</div>

							</a>

							<div class="galy-info">

								<p>Bvlgari Omnia</p>

								<div class="galry">

									<div class="home_item_price"><del>€100.00</del></div>

									<div class="home_new_price">€95.00</div>						

									<div class="clearfix"></div>

								</div>

							</div>

						</div><!-- END of ITEM -->



						<div class="col-md-3 gallery-grid">

							<a href="products.php">

								

								<div class="b-wrapper_sale">

									<div>SALE</div>

								</div>



								<img src="images/g2.png" class="img-responsive" alt=""/>

								<div class="gallery-info">

									<div class="quick">

										<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>

									</div>

								</div>

							</a>

							<div class="galy-info">

								<p>Bvlgari In Black</p>

								<div class="galry">

									<div class="home_item_price"><del>€100.00</del></div>

									<div class="home_new_price">€95.00</div>						

									<div class="clearfix"></div>

								</div>

							</div>

						</div><!-- END of ITEM -->

					

						<div class="clearfix"></div>

					</div>

					

					<div style="text-align:center;"><a class="showSingle button" target="2">See all promotions products</a></div>

				</div>

			</div>

		</div>





		







	</div>
    </div>
</div>





<script>

$(document).ready(function(){

    $(".nav-tabs a").click(function(){

        $(this).tab('show');

    });

});

</script>







<style>.targetDiv {display: none}</style>





<script>



jQuery(function(){

        jQuery('.showSingle').click(function(){

              jQuery('.targetDiv').slideUp();

              jQuery('.targetDiv').hide();

              jQuery('#allproducts'+$(this).attr('target')).slideToggle();

        });

});



</script>