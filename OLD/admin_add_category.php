<?php
$page_title = "ADD CATEGORY";
?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>

<?php include_once "admin_menu.html"; ?>


<div class="container">
	<div class="main_add_category">
		<form method="POST" action="">
			<H2><?php echo $page_title; ?>:</H2>
			<input type="text" name="add_category" /><BR/><BR/><BR/><BR/>
			<input type="submit" value="ADD CATEGORY" />
		</form>
	</div>
</div><!-- END container -->



</body>
</html>
