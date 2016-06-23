<html>

<head>

<title>Perfumes Malta online Shopping</title>

<link href="<?= base_url('assets/css/bootstrap.css') ?>" rel="stylesheet" type="text/css" media="all"/>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css" media="all" />

<link href="<?= base_url('assets/css/owl.carousel.css') ?>" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="keywords" content="" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<script src="<?= base_url('assets/js/jquery-2.2.4.min.js') ?>"></script>

<script>
		baseUrlJS = '<?= base_url(); ?>';
        publicPath = '<?= base_url('main'); ?>';
        uploadsPath = '<?= base_url('assets/uploads') ?>';
</script>

<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-3.1.1.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/scripts.js') ?>"></script>



<!-- cart animation-->



<script type='text/javascript' src="<?= base_url('assets/js/codex-fly.js') ?>"></script>

<!-- cart -->

	<script src="<?= base_url('assets/js/simpleCart.min.js') ?>"> </script>

<!-- cart -->



<script src="<?= base_url('assets/js/imagezoom.js') ?>"></script>



<!-- FlexSlider -->

<script defer src="<?= base_url('assets/js/jquery.flexslider.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/flexslider.css') ?>" type="text/css" media="screen" />



<script>

// Can also be used with $(document).ready()

$(window).load(function() {

  $('.flexslider').flexslider({

    animation: "slide",

    controlNav: "thumbnails"

  });

});

</script>



<!-- the jScrollPane script -->

<script type="text/javascript" src="<?= base_url('assets/js/jquery.jscrollpane.min.js') ?>"></script>

<script type="text/javascript" id="sourcecode">

	$(function()
	{
		$('.scroll-pane').jScrollPane();
	});

</script>

<!-- //the jScrollPane script -->



<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet" type="text/css" media="all" />



<!-- the mousewheel plugin -->

<script type="text/javascript" src="<?= base_url('assets/js/jquery.mousewheel.js') ?>"></script>




</head>

<body>



<!--header-->

<div class="header">

<!--  SET GLOBAL VARIABLE  -->
<?php 

echo '<pre>';
 print_r($_SESSION);
echo '</pre>';

?>
	<div class="header-top">

		<div class="container">

			 <!-- div class="lang_list">

				<select tabindex="4" class="dropdown1">

					<option value="" class="label" value="">En</option>

					<option value="1">English</option>

					<option value="2">French</option>

					<option value="3">German</option>

				</select>

			</div -->

			<div class="top-right">

				<ul>
                                    <?php if(isset($_SESSION['id'])) : ?> 
                                      
                                      <li class='text' id='logOut'>
                                        <span>Welcome, <?= $_SESSION['fullName'] ?> - </span>
                                        <a href="<?= base_url('logout') ?>">logout</a>
                                      </li>;
                                      
                                    <?php else : ?>
                                      
                                      <li class="text"><a href="<?= base_url('login') ?>">login</a></li>
                                      
                                    <?php endif;?>       

					<li>

						<div class="cart box_1">

							<a href="<?= base_url('checkout') ?>" class="cart_anchor">

								<span class="simpleCart_total"> €0.00 </span> (<span id="simpleCart_quantity" class="simpleCart_quantity"> 0 </span>)

							</a>	

							<p><a href="javascript:;" class="simpleCart_empty">Empty cart</a></p>

							<div class="clearfix"> </div>

						</div>

					</li>

				</ul>

			</div>

			<div class="clearfix"></div>

		</div>

	</div>

	<div class="header-bottom">

		<div class="container">

			<!--/.content-->

			<div class="content white">

				<nav class="navbar navbar-default" role="navigation">

					<div class="navbar-header">

						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
                                            <h1 class="navbar-brand"><a  href="<?= base_url('') ?>">perfumes malta</a></h1>
					</div>

					<!--/.navbar-header-->
	
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="<?= base_url('') ?>">Home</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Men <b class="caret"></b></a>
								<ul class="dropdown-menu multi-column columns-3">
									<div class="row">
										<div class="col-sm-4">
											<ul class="multi-column-dropdown">
                                                                                            <?php foreach($brands as $i => $brand) : ?>
                                                                                              <?php if($i <= 4) : ?>
                                                                                                   <li><a class="list1" href="<?= base_url('products').'/'.$brand->id ?>"><?= $brand->brand_name ?></a></li>
                                                                                              <?php endif;?>  
                                                                                            <?php endforeach; ?>        
                                                                                        </ul>
										</div>
										<div class="col-sm-4">
											<ul class="multi-column-dropdown">
											   <?php foreach($brands as $i => $brand) : ?>
                                                                                              <?php if($i >= 5 && $i <= 9) : ?>
                                                                                                   <li><a class="list1" href="<?= base_url('products').'/'.$brand->id ?>"><?= $brand->brand_name ?></a></li>
                                                                                              <?php endif;?>  
                                                                                            <?php endforeach; ?>
                                                                                                   
											</ul>
                                                                                </div>

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">
											    <?php foreach($brands as $i => $brand) : ?>
                                                                                              <?php if($i >= 10 && $i <= 14) : ?>
                                                                                                   <li><a class="list1" href="<?= base_url('products').'/'.$brand->id ?>"><?= $brand->brand_name ?></a></li>
                                                                                              <?php endif;?>  
                                                                                            <?php endforeach; ?>
											</ul>
										</div>										
									</div>
									<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><div class="menu_see_all_brands">SEE ALL BRANDS</div></a>
								</ul>
							</li>
							<li class="dropdown">

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Women <b class="caret"></b></a>

								<ul class="dropdown-menu multi-column columns-3">

									<div class="row">

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

									</div>

								</ul>

							</li>



							<li class="dropdown">

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Top <b class="caret"></b></a>

								<ul class="dropdown-menu multi-column columns-3">

									<div class="row">

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

										<div class="col-sm-4">

											<ul class="multi-column-dropdown">

												<li><a class="list" href="products.php">Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

												<li><a class="list1" href="products.php">Sub Category</a></li>

											</ul>

										</div>

									</div>

								</ul>

							</li>



						 </ul>

					</div>

					 <!--/.navbar-collapse-->

				</nav>

				<!--/.navbar-->

			</div>



			<div class="search-box">

				<div id="sb-search" class="sb-search">

					<form>

						<input class="sb-search-input" placeholder="Enter perfume name..." type="search" name="search" id="search">

						<input class="sb-search-submit" type="submit" value="">

						<span class="sb-icon-search"> </span>

					</form>

				</div>

			</div>

			<!-- search-scripts -->

			<script src="<?= base_url('assets/js/classie.js') ?>"></script>

			<script src="<?= base_url('assets/js/uisearch.js') ?>"></script>

			<script>

				new UISearch( document.getElementById( 'sb-search' ) );

			</script>

			<!-- //search-scripts -->

			<div class="clearfix"></div>

		</div>

	</div>

</div>

<!--header-->