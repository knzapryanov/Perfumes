<html>

<head>

    <title>Perfumes Malta Admin Panel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />

    <link href="<?= base_url('assets/css/bootstrap.css') ?>" rel="stylesheet" type="text/css" media="all"/>
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet" type="text/css" media="all" />
    <script>
        adminPath = '<?= base_url('admin'); ?>';
        uploadsPath = '<?= base_url('assets/uploads') ?>';
    </script>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="<?= base_url('assets/js/jquery-2.2.4.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-3.1.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/scripts.js') ?>"></script>
    <script>
        function myFunction() {
            document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
        }
    </script>
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

		<ul class="topnav">
                    <!--<li><span class="responsive_size responsive_menu_a
                    ctive"><?php echo $page_title; ?></span></li>-->

                    <li><a href="<?= base_url('admin/productPage') ?>"><span class="responsive_size">Add product</span></a></li>

                    <li><a href="<?= base_url('admin/addBrand') ?>"><span class="responsive_size">Add Brand</a></span></li>
                    <li><a href="<?= base_url('admin/allProducts') ?>"><span class="responsive_size">All Products</a></span></li>
                    <li><a href="<?= base_url('admin/newsletter') ?>"><span class="responsive_size">Newsletter</a></span></li>
                    
                    
                    <li class="toRight"><a target="_blank" href="<?= base_url() ?>"><span class="responsive_size">To Site</a></span></li>
                    <li class="toRight"><a href="<?= base_url('logout') ?>"><span class="responsive_size">Logout</a></span></li>
                   
                    <li class="icon">

                    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()" class="responsive_size"><span class="menu_sign responsive_size">&equiv;</span></a>

                    </li>

            </ul>

	</div>
</div>

<!--header-->