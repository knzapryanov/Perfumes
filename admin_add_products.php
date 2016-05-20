<?php
$page_title = "ADD PRODUCTS";
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
	<div class="main_add_products">
		<form method="POST" action="">
			<H2><?php echo $page_title; ?>:</H2>

			<div>
				<h3>Brand:</h3>
				<select name="add_product_brand">
					<option value="bulgari">Choose Brand</option>
					<option value="bulgari">Bulgari</option>
					<option value="azzaro">Azzaro</option>
					<option value="givanchy">Givanchy</option>
				</select>
			</div>

			<div>
				<h3>Name:</h3>
				<input type="text" name="add_product_name" />
			</div>

			<div>
				<h3>Category:</h3>
				<label><input type="checkbox" name="add_product_category_woman" />Woman Perfumes</label><BR/><BR/>
				<label><input type="checkbox" name="add_product_category_men" />Man Perfumes</label><BR/><BR/>
				<label><input type="checkbox" name="add_product_category_top" />Top Perfumes</label><BR/><BR/>
				<label><input type="checkbox" name="add_product_category_newest" />Newest Perfumes</label><BR/><BR/>
				<label><input type="checkbox" name="add_product_category_promotoin" />Promotion Perfumes</label><BR/><BR/>
			</div>

			<div>
				<h3>Description:</h3>
				<textarea name="add_product_description"></textarea>
			</div>

			<div>
				<h3>Photos: <span>FIRST PHOTO WILL BE MAIN</span></h3>
				<input type="file" name="add_product_main_picture" /><BR/>
				<input type="file" name="add_product_second_picture" /><BR/>
				<input type="file" name="add_product_third_picture" /><BR/>
			</div>

			<div>
				<h3>Meta Name:</h3>
				<input type="text" name="add_product_meta_name" /><BR/><BR/>
				<h3>Meta Description:</h3>
				<input type="text" name="add_product_meta_description" /><BR/><BR/>
				<h3>Meta Keywords:</h3>
				<input type="text" name="add_product_meta_keywords" /><BR/><BR/>
				<h3>SEO:</h3>
				<input type="text" name="add_product_seo" />
			</div>

			<div class="add_ml_row">
				<h3>ADD ML ROW</h3>
				<div class="add_remove_buttons">
					<INPUT type="button" value="Add Row" onclick="addRow('dataTable')" class="add_product_table_row"/> 
					<INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable')" class="add_product_remove_table_row"/>
				</div>
			 
				<TABLE id="dataTable">
					<TR>
						<TD class="table_number_row"><INPUT type="checkbox" name="chk"/></TD>
						<TD class="table_ml_row">
							<SELECT name="country">
								<OPTION value="">ML</OPTION>
								<OPTION value="25">25</OPTION>
								<OPTION value="35">35</OPTION>
								<OPTION value="50">50</OPTION>
								<OPTION value="75">75</OPTION>
								<OPTION value="90">90</OPTION>
								<OPTION value="125">125</OPTION>
							</SELECT>
						</TD>
						<TD class="table_main_price_row">MAIN PRICE €<BR><INPUT type="number" id="main_price" name="main_price"/></TD>
						<TD class="table_promo_price_row">PROMO PRICE €<BR><INPUT type="number" id="promo_price" name="promo_price"/><BR><input type="button" onclick="javascript:calc_promo_price()" value="Show Promo Price"/></TD>
						<TD class="table_percent_off_price_row">% OFF PRICE<BR><INPUT type="number" id="percent_off_price" name="percent_off_price"/><BR><input type="button" onclick="javascript:calc_percentage()" value="Show Persentage"/></TD>
						<TD class="table_out_of_stock_row"><label><INPUT type="checkbox" name="out_of_stock"/> Out of stock</label></TD>            
					</TR>
				</TABLE>
			</div>
			
			<BR/><BR/><BR/>
			<input type="submit" value="ADD PRODUCTS" />
		</form>
	</div>
</div><!-- END container -->



</body>
</html>
