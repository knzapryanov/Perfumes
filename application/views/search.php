<div class="content">	<div class="product-model">	 		<div class="container">			<h2 id="headerFilter">Search results by  "<?= $_GET['search'] ?>"</h2>			<!--<div class="showMoreProductsHolder">-->				<div class="col-md-9 product-model-sec">									<!--  HERE LOAD PRODUCT VIA AJAX -->                                                                                                                            <?php if(!empty($sorted)) : ?>                                             <?php foreach($sorted as $product) : ?>                                                    <a href="<?= base_url('product').'/'.$product->slug ?>">						<div class="product-grid">							<div class="more-product"><span> </span></div>							<div class="product-img b-link-stripe b-animate-go  thickbox">								 <img src="<?= base_url('assets/uploads/thumbs').'/'.$product->pictures[0]->source ?>" class="img-responsive" alt="<?= $product->product_name ?>" />                                                                    <?php if(isset($product->is_sale)) : ?>                                                                     <?php if($product->percentage < 30 && $product->percentage !== '') : ?>                                                                            <div class="b-wrapper_sale">                                                                                            <div>SALE</div>                                                                            </div>                                                                     <?php elseif($product->percentage > 30 && $product->percentage !== '') :?>                                                                              <div class="b-wrapper_percent_off">                                                                                             <div><?= $product->percentage ?>%<BR/>OFF</div>                                                                             </div>                                                                     <?php endif; ?>                                                             <?php endif; ?>								<div class="b-wrapper">									<h4 class="b-animate b-from-left  b-delay03">										<button><span class="glyphicon glyphicon-info-sign"></span></button>									</h4>								</div>							</div>						</a>						<div class="product-info simpleCart_shelfItem">							<div class="product-info-cust prt_name">								<h4><?= $product->product_name ?></h4>															<span class="item_price"><?= $product->price  ?></span>								<div class="ofr">                                                                <div class="new_price">                                                                        <p class="pric1"><?= $product->salePrice;  ?></p>                                                                </div>                                                                 <div class="perfum_available_ml">                                                                <select name="perfum_available_ml">                                                                        <?php                                                                        foreach($product->options as $o) {                                                                                ?>                                                                                <option <?= $o->id === $o->id ? '' : '' ?> value="<?= $o->sale_price != 0 ? $o->price . '-' . $o->sale_price . '-' . $o->off_percentage : $o->price ?>" selected="<?= $o->id == $product->smallestOptionId ? 'selected' : '' ?>">                                                                                         <?= $o->ml; ?> ml                                                                                </option>                                                                                <?php                                                                         }                                                                        ?>                                                                </select>																</div>									<div class="clearfix"> </div>								</div>								<input type="number" class="item_quantity" min="1" value="1" />								<button href="javascript:void(0);" class="item_add add-to-cart">									<span class="glyphicon glyphicon-shopping-cart"></span>									<div style="display:none;">										<!--<img src="images/m1.jpg" class="img-responsive" alt="">-->									</div>								</button>								<div class="clearfix"> </div>							</div>						</div>					</div>								  <?php endforeach; ?>								 <?php else : ?>								  <h3>Not found products</h3>								 <?php endif; ?>									<!-- End of ITEM -->					<div class="clearfix"></div>			</div>		<div style="text-align:center;">			<a style="display: none;" class="button loadFilteredProducts" target="1">See more products</a>		</div>			<div class="rsidebar_filter" style="">				<div class="product_right">					<h4 class="m_2"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Categories</h4><BR/>					<div class="left_side_categories">								                                            <a href="<?= base_url('products?cat=woman') ?>"><div cat="woman" class="">Woman Perfumes</div></a>						<a href="<?= base_url('products?cat=man') ?>"><div cat="man" class="">Man Perfumes</div></a>						<a href="<?= base_url('products?cat=top') ?>"><div cat="top" class="">Top Perfumes</div></a>						<a href="<?= base_url('products?cat=newest') ?>"><div  cat="newest"class="">Newest Perfumes</div></a>						<a href="<?= base_url('products?cat=promo') ?>"><div cat="promo" class="">Promotion Perfumes</div></a>					</div>				</div>				 			</div><!-- END rsidebar_filter -->    </div></div><!----></div>	