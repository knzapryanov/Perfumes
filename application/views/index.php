<div class="banner-section" style="margin:0 0 20px 0;">

	<div class="container">

		<div class="banner-grids">

			<div class="col-md-6 banner-grid">

				<h2>The Lates Perfumes</h2>

				<p>Wellcome to our perfumes shop. Here you can find the biggest collection of all original perfumes you need ! We can offer you the lowest prices and over 1500 perfumes.</p>

				<a href="<?= base_url('products').'?cat=man&brand=' ?>" class="button"> shop now </a>

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

						<div class="tab_inside_main_large_text">
                                                    <span>PROMOTIONS</span>
                                                </div>

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

				<div class="gallery-grids">
                                    
                                        <?php foreach($manualNewest as $product) : ?>   
                                      	<div class="col-md-3 gallery-grid ">
                                            <a href="<?= base_url('product').'/'.$product->slug ?>">
                                                        
                                                <?php if(isset($product->is_sale)) : ?>
                                                    <?php if($product->percentage < 30 && $product->percentage !== '') : ?>

                                                         <div class="b-wrapper_sale">
                                                                 <div>SALE</div>
                                                         </div>

                                                    <?php elseif($product->percentage > 30 && $product->percentage !== '') :?>     
                                                          <div class="b-wrapper_percent_off">
                                                                 <div><?= $product->percentage ?>%<BR/>OFF</div>
                                                         </div>
                                                     <?php endif; ?>    
                                              <?php endif; ?>    
                                                
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
                                                                <div class="home_item_price"><?= $product->price  ?></div>
                                                                <div class="home_new_price"><?= $product->salePrice  ?></div>
                                                              
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
			
                                        <?php endforeach; ?>
                                        
					<div class="clearfix"></div>
                                        
					</div>
                                <!-- END GALLERY -->
                                      <?php if(!isset($emptymanualNewest) && count($manualNewest) === 12) :?>
                            		<div style="text-align:center;"><a attr-method="loadManual" class="button loadProducts" target="1">See more newest products</a></div>
                                      <?php endif; ?>
                    		</div>

			</div>

		</div>


	<div id="promotions" class="tab-pane fade">
		<div class="gallery">

			<div class="container">


				<div class="gallery-grids">
                        <?php foreach($promotions as $promo) : ?>
                        <div class="col-md-3 gallery-grid ">
                            <a href="<?= base_url('product').'/'.$promo->slug ?>">

                                    <?php if($promo->percentage < 30) : ?>
                                         <div class="b-wrapper_sale">
                                                 <div>SALE</div>
                                         </div>

                                    <?php else :?>
                                          <div class="b-wrapper_percent_off">
                                                 <div><?= $promo->percentage ?>%<BR/>OFF</div>
                                         </div>
                                     <?php endif; ?>

                                <img src="<?= base_url('assets/uploads/thumbs').'/'.$promo->pictures[0]->source ?>" class="img-responsive" alt="<?= $promo->product_name ?>" />
							<div class="gallery-info">
								<div class="quick">
									<p><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</p>
								</div>
							</div>
						</a>
						<div class="galy-info">
							<p><?= $promo->product_name ?></p>
							<div class="galry">
									<div class="home_item_price"><?= $promo->price  ?></div>
									<div class="home_new_price"><?= $promo->salePrice  ?></div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
			
                    <?php endforeach; ?>

					<div class="clearfix"></div>
                                        
					</div>
                                <!-- END GALLERY -->
                                        <?php if(!isset($emptypromotions) && count($promotions) === 12) :?>
                                            <div style="text-align:center;"><a attr-method="loadPromotions" class="button loadProducts" target="1">See more promotional products</a></div>
                                        <?php endif; ?>    
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